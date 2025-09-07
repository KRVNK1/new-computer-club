<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Models\Workstation;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    // Список тарифов
    public function tariffs()
    {
        $tariffs = Tariff::paginate(6);
        $activeTab = 'tariffs';

        return view('admin.dashboard', compact('tariffs', 'activeTab'));
    }

    // Создание тарифа(представление)
    public function createTariff()
    {
        return view('admin.tariffs.create');
    }

    // Сохранение тарифа
    public function storeTariff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_room' => 'boolean',
            'image' => 'nullable|image|max:255',
        ]);

        // Создание тарифа
        $tariff = new Tariff();
        $tariff->name = $validated['name'];
        $tariff->price_per_hour = $validated['price_per_hour'];
        $tariff->is_room = $request->has('is_room') ? 1 : 0;

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // getClientOriginalExtension - Указание типа файла 
            $image->move(public_path('/img/tariffs'), $imageName); // Перенос картинки в img/tariffs
            $tariff->image = '/img/tariffs/' . $imageName;
        } else {
            $tariff->image = '/img/tariffs/pc2.png'; // если картинка не загружена берется стандартная картинка
        }

        $tariff->save();

        return redirect()->route('admin.tariffs')->with('success', 'Тариф успешно создан');
    }

    // Редактирование тарифа(представление)
    public function editTariff($id)
    {
        $tariff = Tariff::findOrFail($id);
        return view('admin.tariffs.edit', compact('tariff'));
    }

    // Обновление тарифа
    public function updateTariff(Request $request, $id)
    {
        $tariff = Tariff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_room' => 'boolean',
            'image' => 'nullable|image|max:255',
        ]);

        $tariff->name = $validated['name'];
        $tariff->price_per_hour = $validated['price_per_hour'];
        $tariff->is_room = $request->has('is_room') ? 1 : 0;

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/tariffs'), $imageName);
            $tariff->image = 'img/tariffs/' . $imageName;
        }

        $tariff->save();

        return redirect()->route('admin.tariffs')->with('success', 'Данные тарифа обновлены');
    }

    // Удаление тарифа
    public function deleteTariff($id)
    {
        $tariff = Tariff::findOrFail($id);

        $workstationsCount = Workstation::where('type', $tariff->name)->count();

        if ($workstationsCount > 0) {
            return redirect()->route('admin.tariffs')->with('error', "Нельзя удалить тариф {$tariff->name}, т.к в нем есть рабочие места");
        }

        $tariff->delete();

        return redirect()->route('admin.tariffs')->with('success', 'Тариф удален');
    }
}
