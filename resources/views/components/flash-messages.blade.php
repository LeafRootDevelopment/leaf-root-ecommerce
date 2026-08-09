@if (session('success'))
    <div style="color: green; background: #e6f4ea; padding: 10px; margin-bottom: 15px; border: 1px solid green;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="color: red; background: #fce8e6; padding: 10px; margin-bottom: 15px; border: 1px solid red;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red; background: #fce8e6; padding: 10px; margin-bottom: 15px; border: 1px solid red;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  