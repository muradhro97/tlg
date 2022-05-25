@include('partials.validation-errors')
{!! Field::floatOnly('rest' , trans('main.rest') ) !!}
<input type="hidden" name="amount" value="{{$model->amount}}">
<input type="hidden" name="id" value="{{$model->id}}">



@push('script')
    <script>

        $("body").on("keyup", "#rest", function (e) {
//alert();
//            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                //display error message
                // console.log( $(this).next().next());
                $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
//                $(this).next().text("برجاء ادخال ارقام فقط").show().fadeOut(2000);
                return false;
            }
            let amount =    $('[name="amount"]').val();
            let rest =    $('[name="rest"]').val();
            amount = parseFloat(amount);
            rest = parseFloat(rest);
//        money.toFixed(4);
//        console.log(money);
//        console.log(rest);
            if (rest > amount) {
//                console.log(123);
                rest = amount;
                $("#rest").val(rest);
                $(this).next().text("{{trans('main.rest_bigger_than_custody_amount')}}").show().fadeOut(2000);
            }
//            let val = $(this).val();
//            let max = total;
//            val = Number(val);
//            max = Number(max);
//            if (val > max) {
//                $(this).val(max);
//            }

        });
    </script>
@endpush