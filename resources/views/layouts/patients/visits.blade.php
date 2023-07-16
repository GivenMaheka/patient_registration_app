@extends('layouts.patients.index',['title'=>'Patient | List', 'tab'=>'visit'])
@section('content')
<div class=' mt-5 mx-5 self-center  bg-white shadow-md rounded-md  md:py-4 h-max
            relative overflow-x-auto py-2 px-3'>
    <div class="mb-4 px-4 flex flex-row-reverse">
        <input class="outline-none py-2 px-3 border-b border-gray-300" type="text" id="" placeholder="Search...">
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-sm">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50  dark:text-gray-400 w-full">
            <tr class="">
                <th scope="col" class="px-2 py-3">Patient Name</th>
                <th scope="col" class="px-2 py-3">Age</th>
                <th scope="col" class="px-2 py-3">Height</th>
                <th scope="col" class="px-2 py-3">Weight</th>
                <th scope="col" class="px-2 py-3">Health</th>
                <th scope="col" class="px-2 py-3">On Drugs</th>
                <th scope="col" class="px-2 py-3">On Diet</th>
                <th scope="col" class="px-2 py-3 date-col">Date <i class="fa fa-filter text-sm"></i></th>
                <th scope="col" class="px-2 py-3"><span class="mr-2">BMI</span></th>
                <th scope="col" class="px-2 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $patient)
            <tr class="bg-white border-b  hover:bg-gray-50 dark:hover:bg-gray-200 relative">
                <td data-col="Patient Name" scope="row" class="px-2 py-4">
                    {{$patient->Patient_name}}
                </td>
                <td data-col="Age" class="px-2 py-4">{{$patient->age}}</td>
                <td data-col="Height" class="px-2 py-4">{{$patient->height}}</td>
                <td data-col="Weight" class="px-2 py-4">{{$patient->weight}}</td>
                <td data-col="Health" class="px-2 py-4 capitalize">{{$patient->health}}</td>
                <td data-col="On Drugs" class="px-2 py-4 capitalize">{{empty($patient->onDrugs)?'-':$patient->onDrugs}}</td>
                <td data-col="On Diet" class="px-2 py-4 capitalize">{{empty($patient->onDiet)?'-':$patient->onDiet}}</td>
                <td data-col="Date" class="px-2 py-4">{{$patient->date}}</td>
                <td data-col="BMI" class="px-2 py-4 capitalize">
                    <span class='w-full top-0 mr-2 {{($patient->bmiVal < 18.5) ? "text-red-700" : (($patient->bmiVal > 18.5 && $patient->bmiVal < 25) ? "text-green-500" : "text-blue-700")}}'>{{$patient->bmiVal}}</span>
                    {{$patient->bmi}}
                </td>
                <td class="px-2 py-4 text-blue-900 cursor-pointer view-comments" onclick="ShowComments(event)">
                More
                <p class="hidden">{{$patient->comments}}</p>
            </td>
            </tr>
            
            
            @endforeach
        </tbody>
    </table>
</div>
@endsection