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
            <form action="{{route('new.formSave')}}" method="post" class=" px-8 h-4/5 w-full md:px-0 md:h-full md:w-3/5 md:pl-3">@csrf
                <h3 class="text-4xl font-bold my-8 capitalize">vital form A</h3>

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
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="height">
                            General Health?
                        </label>
                        <div class="grid gap-3">
                            <div class="w-full form-radio-control gap-10"><input class="cursor-pointer" type="radio" name="general_health"  value="good" id="good"><label class="cursor-pointer" for='good'>Good</label></div>
                            <div class="w-full form-radio-control gap-10"><input class="cursor-pointer" type="radio" name="general_health"  value="bad" id="bad"> <label class="cursor-pointer" for='bad'>Bad</label></div>
                        </div>
                        
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">
                            Have you ever been on diet to loose weight?
                        </label>
                        <div class="grid gap-3">
                            <div class="w-full form-radio-control gap-10"><input class="cursor-pointer" type="radio" name="ondiet"  value="yes" id="yes"><label class="cursor-pointer" for='yes'>Yes</label></div>
                            <div class="w-full form-radio-control gap-10"><input class="cursor-pointer" type="radio" name="ondiet"  value="no" id="no"> <label class="cursor-pointer" for='no'>No</label></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">Comments</label>
                        <textarea class="
                        shadow appearance-none border rounded w-full py-2 px-3 resize-none h-24
                        text-gray-400 leading-tight focus:outline-none focus:shadow-outline disabled:bg-slate-200
                        " type="text" name="comment" id="comment"> </textarea>
                    </div>
                </div>
                <button class="w-full bg-black text-white rounded-md py-1 px-6" type="submit">Save</button>
                <a class="w-full bg-gray-200 text-gray-400 rounded-md mt-2 py-1 px-6 block text-center" href="{{route('back.vital',[Session::get('patient_id')])}}">Back</a>
            </form>
            <div class="image-view w-full h-auto ml-0 md:w-2/5 md:ml-4 md:h-full bg-[#24A7EE] overflow-hidden grid place-items-center rounded-t-3xl rounded-tr-3xl md:rounded-xl p-0 ">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/002/737/789/small_2x/medical-doctor-visiting-patient-illustration-concept-free-vector.jpg" alt="" srcset="">
            </div>
        </div>
        <p class="text-center text-gray-500 text-xs py-5">&copy;2023 Patient Registration App. All right Reserved</p>
    </main>
</body>

</html>
<script src="{{asset('assets/js/script.js')}}" defer></script>
@else
<script> location.href='{{route("newPatient")}}'</script>
@endif