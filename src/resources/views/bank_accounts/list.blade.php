@foreach($bankAccounts as $bankAccount)
    <div>
        口座番号: {{ $bankAccount['account_number'] }}<br>
        残高: {{ $bankAccount['balance'] }}
    </div>
    <hr>
@endforeach
