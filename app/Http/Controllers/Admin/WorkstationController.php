<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Models\Workstation;
use Illuminate\Http\Request;

class WorkstationController extends Controller
{
    // Список рабочих мест
    public function workstations()
    {
        $workstations = Workstation::paginate(6);
        $activeTab = 'workstations';

        return view('admin.dashboard', compact('workstations', 'activeTab'));
    }

    // Создание рабочих мест(представление)
    public function createWorkstation()
    {
        $tariffs = Tariff::all();
        return view('admin.workstations.create', compact('tariffs'));
    }

    // Сохранение рабочего места
    public function storeWorkstation(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:workstations',
            'type' => 'required|string|max:255',
            'status' => 'required|in:Свободно,Занято',
        ]);

        $workstation = new Workstation();
        $workstation->number = $validated['number'];
        $workstation->type = $validated['type'];
        $workstation->status = $validated['status'];
        $workstation->save();

        return redirect()->route('admin.workstations')->with('success', 'Рабочее место успешно создано');
    }

    // Редактирование рабочего места
    public function editWorkstation($id)
    {
        $workstation = Workstation::findOrFail($id);
        $tariffs = Tariff::all();
        return view('admin.workstations.edit', compact('workstation', 'tariffs'));
    }

    // Обновление рабочего места
    public function updateWorkstation(Request $request, $id)
    {
        $workstation = Workstation::findOrFail($id);

        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:workstations,number,' . $id,
            'type' => 'required|string|max:255',
        ]);

        $workstation->number = $validated['number'];
        $workstation->type = $validated['type'];
        $workstation->save();

        return redirect()->route('admin.workstations')->with('success', 'Данные рабочего места обновлены');
    }

    // Удаление рабочего места
    public function deleteWorkstation($id)
    {
        $workstation = Workstation::findOrFail($id);

        if ($workstation->status == 'Занято') {
            return redirect()->route('admin.workstations')->with('error', 'Нельзя удалить занятое рабочее место');
        }

        $workstation->delete();

        return redirect()->route('admin.workstations')->with('success', 'Рабочее место удалено');
    }
}
