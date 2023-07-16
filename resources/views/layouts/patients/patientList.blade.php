@extends('layouts.patients.index',['title'=>'Patient | List', 'tab'=>'patient'])
@section('content')
<div class=' mt-5 mx-5 self-center  bg-white shadow-md rounded-md  md:py-4 h-max
            relative overflow-x-auto py-2 px-3'>
    
    {{json_encode(Auth::user())}}
    {{json_encode($user)}}

    <a href="{{route('logout')}}">Logout</a>
    <div class="mb-4 px-4 flex flex-row-reverse">
        <input class="outline-none py-2 px-3 border-b border-gray-300" type="text" id="" placeholder="Search...">
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-sm">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50  dark:text-gray-400 w-full">
            <tr class="">
                <th scope="col" class="px-2 py-3">Patient Name</th>
                <th scope="col" class="px-2 py-3">Email</th>
                <th scope="col" class="px-2 py-3 "><span class="mr-2">Age</span> <i class="fa fa-filter text-sm"></i></th>
                <th scope="col" class="px-2 py-3 "><span class="mr-2">Gender</span> <i class="fa fa-filter text-sm"></i></th>
                <th scope="col" class="px-2 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $patent)
            <tr class="bg-white border-b  hover:bg-gray-50 dark:hover:bg-gray-200">
                <td data-col="Patient Name" scope="row" class="px-2 py-4">
                    {{$patent->first_name.' '.$patent->last_name}}
                </td>
                <td data-col="Email" class="px-2 py-4">{{$patent->email}}</td>
                <td data-col="Age" class="px-2 py-4">{{(integer)date_diff(date_create($patent->birth_date),date_create('now'))->format("%Y%") * 1}}</td>
                <td data-col="Gender" class="px-2 py-4 capitalize">{{$patent->gender}}</td>
                <td class="px-2 py-4 capitalize text-blue-900"><a href="{{route('new.visit',[Crypt::encrypt($patent->patient_id)])}}">New Visit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection