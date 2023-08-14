@extends('layouts.app')

@section('content')
<center>
    <h2>Datos cliente</h2>
    <p> Correo: {{ $user->email }}</p>
    <p>Nombre completo: {{ $user->name.' '.$user->surname }}</p>
    
    <h2>Formulario plan</h2>
    <form method="POST">
        @csrf
        <label>Fecha inicio</label>
        <input name="initiation_date" type="date"><br/>

        <label>Fecha fin</label>
        <input name="expiration_date" type="date"><br/>

        <label>Monto</label>
        <input name="amount" type="number" step="0.10"><br/>

        <label>Método de pago</label>
        <select name="payment_method_id">
            @foreach ($payment_methods as $payment_method)
                <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
            @endforeach
        </select><br/>
        
        <input type="submit" value="Crear plan">
    </form>
</center>
@endsection