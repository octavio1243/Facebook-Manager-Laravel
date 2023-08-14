<h2>Historial de facturación</h2>
<table border="1">
    <tr>
        <th>Fecha de inicio</th>
        <th>Fecha de fin</th>
        <th>Monto</th>
        <th>Método de pago</th>
    </tr>
    @foreach ($plans as $plan)
    <tr>
        <th>{{ $plan->initiation_date }}</th>
        <th>{{ $plan->expiration_date }}</th>
        <th>{{ $plan->amount }}</th>
        <th>{{ $plan->payment_method->name }}</th>
    </tr>
    @endforeach
</table>