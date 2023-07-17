<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat Alternates">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
</head>

<body class="w-full h-screen bg-gray-200 flex">
    <div class="menuContainer flex left-[-100%] z-[5] md:z-[1] md:left-[0%] w-full md:w-60 top-0 absolute md:relative overflow-hidden h-full">
        <nav class="md:w-full w-60 h-full flex flex-col justify-between bg-[#1b709e]">
            <ul class="m-0 text-slate-200 grid gap-3 pt-10">
                <li class="py-3 px-4">Dashboard</li>
                <li><a href="{{route('newPatient')}}" class="block py-3 px-4">Patient Registration</a></li>
                <li class="bg-white text-[#1b709e]"><a href="{{route('get.visits')}}" class="block py-3 px-4">Patient Visit Details</a></li>
            </ul>
            <a class="w-full py-2 px-4 bg-red-900 hover:bg-red-800 text-white" href="{{route('logout')}}">Logout</a>
        </nav>
        <div class="md:hidden h-full w-full bg-[rgba(176,195,215,0.5)]"></div>
        <div class="md:hidden absolute top-5 right-5 p-1 rounded-xl text-blue-900 cursor-pointer text-lg" onclick="menuContainer()">X</div>
    </div>
    <main class="w-full h-screen overflow-auto flex flex-col justify-between">
        <div class="main-container w-full">
            <div class="h-max items-center mb-3 bg-white p-2 flex justify-between sticky top-0 z-[4]">
                <div class="logo px-2 font-extrabold text-xl tracking-wider text-[#1b709e]">Logo</div>
                <div class="flex gap-4 items-center mr-3">
                    <div class="flex gap-3 items-center content-center">
                        <img class="rounded-full w-10 h-10 shadow-md" src="https://static.vecteezy.com/system/resources/thumbnails/002/737/789/small_2x/medical-doctor-visiting-patient-illustration-concept-free-vector.jpg" alt="">
                        <p class="text-slate-300">{{Auth::user()->first_name}}</p>
                    </div>
                    <div onclick="menuContainer()" class=" md:hidden p-1 h-6 cursor-pointer text-slate-400 grid place-items-center fa fa-bars">
                        
                    </div>
                </div>
            </div>
            <div class=' mt-5 mx-5 self-center  bg-white shadow-md rounded-xl  p-0 px-3 h-max
            relative overflow-x-auto sm:rounded-md'>
                <ul class="tab-list m-0 flex gap-2 text-gray-400 font-semibold text-sm uppercase">
                    <li class=""><a class="p-3 block" href="{{route('newPatient')}}">New Patient</a></li>
                    <li class="{{($tab == 'patient')? 'active' : ''}}"><a class="p-3 block" href="{{route('get.patients')}}">Patients</a></li>
                    <li class="{{($tab == 'visit')? 'active' : ''}}"><a class="p-3 block" href="{{route('get.visits')}}">Visits</a></li>
                </ul>
            </div>
            @yield('content')
        </div>
        <p class="text-center text-gray-500 text-xs py-5 ">&copy;2023 Patient Registration App. All right Reserved</p>
    </main>
</body>

</html>
<script src="{{asset('assets/js/script.js')}}" defer></script>
<script>
        let getCellValue = function(tr, idx) {
            return tr.children[idx].innerText || tr.children[idx].textContent
        }
        let comparer = function(idx, asc) {
            return function(a, b) {
                return function(v1, v2) {
                    return v1 !== "" && v2 !== "" && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2);
                }(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));
            }
        };

        let Allth = document.querySelectorAll('th')


        Allth.forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table');
            const tbody = table.querySelector('tbody');
            Array.from(tbody.querySelectorAll('tr'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => tbody.appendChild(tr));
        })))

        function menuContainer(){
            let menu = document.querySelector('.menuContainer');

            if(menu.getBoundingClientRect().left < 0){
                menu.style.left = '0%';
            }else{
                menu.style.left = '-100%';
            }
        }
    
</script>