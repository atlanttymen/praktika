<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $currentDate = Carbon::createFromDate($year, $month, 1);

        $calendars = Calendar::all();
    
        // Получаем текущую дату
        $currentDate = now();
    
        // Получаем первый и последний день месяца
        $firstDayOfMonth = $currentDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentDate->copy()->endOfMonth();
    
        // Получаем количество дней в месяце
        $daysInMonth = $lastDayOfMonth->day;
    
        // Получаем день недели для первого дня месяца (0 = воскресенье, 6 = суббота)
        $firstDayOfWeek = $firstDayOfMonth->dayOfWeek;
    
        // Если календарь начинается с понедельника, корректируем день недели
        if ($firstDayOfWeek == 0) { // Воскресенье
            $firstDayOfWeek = 6; // Устанавливаем его на 6 (суббота)
        } else {
            $firstDayOfWeek--; // Сдвигаем на 1, чтобы понедельник был 0
        }
    
        return view('calendars.index', compact('calendars', 'firstDayOfWeek', 'daysInMonth', 'currentDate'));
    }

    public function create()
    {
        return view('calendars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255', // Валидация для поля местоположения
            'is_all_day' => 'boolean', // Валидация для флага события на весь день
        ]);

        Calendar::create($request->all());
        return redirect()->route('calendars.index')->with('success', 'Событие успешно создано!');
    }

    public function edit(Calendar $calendar)
    {
        return view('calendars.edit', compact('calendar'));
    }

    public function update(Request $request, Calendar $calendar)
    {
        $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'is_all_day' => 'boolean',
        ]);

        $calendar->update($request->all());
        return redirect()->route('calendars.index')->with('success', 'Событие успешно обновлено!');
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return redirect()->route('calendars.index')->with('success', 'Событие успешно удалено!');
    }
}
