@auth
<script> window.location.href = "{{route('get.patients')}}"</script>
@endauth
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
        <div class='w-11/12 md:w-8/12 mt-5 self-center flex flex-col-reverse flex-grow md:flex-row bg-white shadow-md rounded-3xl md:px-3 md:py-8 p-0 h-max'>
            <form action="{{route('auth.staff')}}" method="post" class=" px-8 h-4/5 w-full md:px-0 md:h-full md:w-3/5 md:pl-3">@csrf
                <h3 class="text-4xl font-bold my-8">Login</h3>

                @if(Session::has('login_fail') )
                    <div class="text-white py-2 rounded-md mb-2 text-sm bg-red-900 grid place-items-center">
                        <p class='m-0 p-0'>
                        {{Session::get('login_fail')}}
                        </p>
                    </div>
                @endif
                <div class="input-container flex flex-col justify-center">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input class="
                        shadow appearance-none border rounded w-full py-2 px-3
                        text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                        " type="email" name="email" id="email" value="{{old('email')}}" placeholder="User Email">
                        <span class="text-red-800 text-xs">@error('email') {{$message}} @enderror</span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input class="
                        shadow appearance-none border rounded w-full py-2 px-3
                        text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                        " type="password" name="password" id="password" placeholder="Password">
                        <span class="text-red-800 text-xs">@error('password') {{$message}} @enderror</span>
                    </div>
                </div>
                <button class="w-full bg-black text-white rounded-md py-1 px-6" type="submit">Login</button>
            </form>
            <div class="image-view w-full h-1/5 ml-0 md:w-2/5 md:ml-4 md:h-full bg-[#24A7EE] overflow-hidden grid place-items-center rounded-t-3xl rounded-tr-3xl md:rounded-xl p-0 ">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/002/737/789/small_2x/medical-doctor-visiting-patient-illustration-concept-free-vector.jpg" alt="" srcset="">
            </div>
        </div>
        <p class="text-center text-gray-500 text-xs py-5">&copy;2023 Patient Registration App. All right Reserved</p>
    </main>
</body>
</html>