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
    <div class="w-60 top-0 left-[-100%] absolute md:relative md:left-[0%] overflow-hidden h-full bg-[#1b709e]">
        <nav class="">
            <ul class="m-0 text-slate-200">
                <li class="py-3 px-4">Dashboard</li>
                <li class="py-3 px-4">New Patient</li>
                <li class="py-3 px-4">Visits</li>
                <li class="py-3 px-4">{{Auth::user()}}</li>
            </ul>

        </nav>
    </div>
    <main class="w-full h-screen overflow-auto flex flex-col justify-between">
        <div class="main-container w-full">
            <div class="h-max items-center mb-3 bg-white p-2 flex justify-between sticky top-0 z-10">
                <div class="logo px-2">Logo</div>
                <div class="flex gap-4 items-center mr-3">
                    <div class="flex gap-3 items-center content-center">
                        <img class="rounded-full w-10 h-10 shadow-md" src="https://static.vecteezy.com/system/resources/thumbnails/002/737/789/small_2x/medical-doctor-visiting-patient-illustration-concept-free-vector.jpg" alt="">
                        <p class="text-slate-300">Help Desk</p>
                    </div>
                    <div class=" md:hidden p-1 h-6 cursor-pointer text-slate-400 grid place-items-center fa fa-bars">
                        <svg viewbox="0 0 100 80" class="w-5">
                            <rect fill="#707b83" width="100" height="20"></rect>
                            <rect fill="#707b83" y="30" width="100" height="20"></rect>
                            <rect fill="#707b83" y="60" width="100" height="20"></rect>
                        </svg>
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
    
</script>