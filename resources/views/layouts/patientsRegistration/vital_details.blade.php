@if(Session::has('patient_id'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration App</title>
    @vite('resources/css/app.css')
</head>

<body class="w-full h-screen bg-gray-200">
    <main class="w-full h-full flex flex-col justify-stretch">
        <div class='w-8/12 mt-5 self-center flex flex-col-reverse flex-grow md:flex-row bg-white shadow-md rounded-3xl md:px-3 md:py-8 p-0 h-max'>
            <form action="{{route('new.vital')}}" method="post" class=" px-8 h-4/5 w-full md:px-0 md:h-full md:w-3/5 md:pl-3">@csrf
                <h3 class="text-4xl font-bold my-8 capitalize">vitals form</h3>

                @if(Session::has('entry_success') )
                <div class="text-white py-2 rounded-md mb-2 text-sm bg-green-900 grid place-items-center">
                    <p class='m-0 p-0'>
                        {{Session::get('entry_success')}}
                    </p>
                </div>
                @endif
                @if(Session::has('entry_error') )
                <div class="text-white py-2 rounded-md mb-2 text-sm bg-red-900 grid place-items-center">
                    <p class='m-0 p-0'>
                        {{Session::get('entry_error')}}
                    </p>
                </div>
                @endif
                <div class="input-container flex flex-col justify-center">
                    <input type="hidden" name="patient_id" value="{{ Session::get('patient_id')}}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date</label>
                        <input class="
                        shadow appearance-none border rounded w-full py-2 px-3
                        text-gray-400 leading-tight focus:outline-none focus:shadow-outline disabled:bg-slate-200
                        " type="date" name="date" id="date" placeholder="Firstname" disabled value="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="height">Height</label>
                        <div class="form-input-control shadow appearance-none border rounded w-full overflow-hidden
                            text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @if(Session::has('data'))
                            <input class="py-2 px-3 outline-none flex-grow" type="text" name="height" id="height" onchange="GetBMI(event)" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g,'')" value="{{Session::get('data')->Height}}">
                            @else
                            <input class="py-2 px-3 outline-none flex-grow" type="text" name="height" id="height" onchange="GetBMI(event)" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g,'')" placeholder="height">
                            @endif
                            <span class=" m-0 w-10 h-full text-gray-400 bg-gray-200 grid place-items-center">Cm</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">Weight</label>
                        <div class="form-input-control shadow appearance-none border rounded w-full overflow-hidden
                            text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @if(Session::has('data'))
                            <input class="py-2 px-3 outline-none flex-grow" type="text" name="weight" onchange="GetBMI(event)" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g,'')" id="weight" value="{{Session::get('data')->weight}}">
                            @else
                            <input class="py-2 px-3 outline-none flex-grow" type="text" name="weight" onchange="GetBMI(event)" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g,'')" id="weight" placeholder="weight">
                            @endif
                            <span class=" m-0 w-10 h-full text-gray-400 bg-gray-200 grid place-items-center">Kg</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="bmi">BMI</label>
                        <input class="
                        shadow appearance-none border rounded w-full py-2 px-3
                        text-gray-400 leading-tight focus:outline-none focus:shadow-outline disabled:bg-slate-200
                        " type="text" name="bmi" id="bmi" disabled>
                    </div>
                </div>
                <button class="w-full bg-black text-white rounded-md py-1 px-6" type="submit">Next</button>
                <!-- <button class="w-full bg-gray-200 text-gray-400 rounded-md mt-2 py-1 px-6" onclick="Cancel(event)">Cancel</button> -->
                <a class="w-full block text-center bg-gray-200 text-gray-400 rounded-md mt-2 py-1 px-6" href="{{route('cancel.vital',[Session::get('patient_id')])}}">Cancel</a>
            </form>
            <div class="image-view w-full h-1/5 ml-0 md:w-2/5 md:ml-4 md:h-full bg-[#24A7EE] overflow-hidden grid place-items-center rounded-t-3xl rounded-tr-3xl md:rounded-xl p-0 ">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/002/737/789/small_2x/medical-doctor-visiting-patient-illustration-concept-free-vector.jpg" alt="" srcset="">
            </div>
        </div>
        <p class="text-center text-gray-500 text-xs py-5">&copy;2023 Patient Registration App. All right Reserved</p>
    </main>
</body>

</html>
<script>
    let HEIGHT_FIELD = document.querySelector('#height'),
        WEIGHT_FIELD = document.querySelector('#weight'),
        BMI_FIELD = document.querySelector('#bmi');

    function GetBMI(e) {
        e.preventDefault();

        let w = WEIGHT_FIELD.value,
            h = HEIGHT_FIELD.value;
        const BMI_VAL = (w == null || w == "") ? 0 : parseFloat(w) / Math.pow((h == null || h == "") ? 0 : (parseInt(h) * .01), 2);
        BMI_FIELD.value = `${BMI_VAL.toFixed(2)} Kg/m2`;
    }

    function Cancel(e) {
        e.preventDefault();

        HEIGHT_FIELD.value = ''
        WEIGHT_FIELD.value = ''
        BMI_FIELD.value = ''
    }
</script>
@else
<script> location.href='{{route("newPatient")}}'</script>
@endif
