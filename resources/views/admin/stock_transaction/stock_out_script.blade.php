@push('script')


    <script>

        var items = [];
        var counter = 0;
        var total = 0;


        $(function () {
            calcAll();
        });
        $(document).on('click', '#add-item', function (e) {
            e.preventDefault();


            let item_name = $("#item_id option:selected").text();
            let item_id = $("#item_id option:selected").val();
            let price = $("input[name='price']").val();
            let quantity = $("input[name='quantity']").val();
            let item_total = price * quantity;
//            console.log(item_total);
            item_total = item_total.toFixed(4);
//            console.log(item_total);
            if (item_id === "" || price === "" || quantity === "") {
                return false;
            }
//            console.log(item_id);
            $("input[name='item_id']").val("");
            $("#item_id").val(null).trigger('change');
//            $("input[name='buy_date']").val(today2);
            $("input[name='quantity']").val("");
            $("input[name='price']").val("");
//            let index = items.findIndex(x => x.item_id === item_id);
            let item = {};

            counter += 1;

            item.id = counter;
            item.item_id = item_id;
            item.item_name = item_name;
            item.quantity = quantity;
            item.price = price;
            item.total = item_total;
//            console.log(item_total);
//            console.log(total);
            total = parseFloat(total) + parseFloat(item_total);

            items.push(item);
//            console.log(quantity);
            $(".item-append-area").prepend(
                `
         <tr class="sec-content-row" itemid="${counter}" >
            <!--<td>${counter}</td>-->
            <td>${item_name}</td>
            <td>${quantity}</td>
            <td>${price}</td>
            <td>${item_total}</td>


            <td class="text-center">

                <button type="button" class="destroy btn btn-danger btn-xs remove-item"><i
                            class="fa fa-trash-o"></i></button>

            </td>
        </tr>
                `
            );

            calcAll()

        });


        $("body").on("click", ".remove-item", function () {

            let parentTr = $(this).parents(".sec-content-row");

            let id = parentTr.attr("itemid");
            id = parseInt(id);
            let index = items.findIndex(x => x.id === id);

            let item = findObjectByKey(items, 'id', id);

            total = total - parseFloat(items[index]['total']);

            calcAll();

            items.splice(index, 1);


            parentTr.remove();


        });

        function findObjectByKey(array, key, value) {
            for (var i = 0; i < array.length; i++) {
//                console.log(array[i][key]);
//                console.log(value);
                if (array[i][key] === value) {
                    return array[i];
                }
            }
            return null;
        }


        function calcAll() {
//            console.log(total);
            total = parseFloat(total).toFixed(4);
            $(".total").text(total);
            $("#total").val(total);
            let itemsToSend = JSON.stringify(items);

            $('input[name="items"]').val(itemsToSend);

        }


        $("body").on("change", "#item_id", function () {
            let object = $("#item_id option:selected");
            let item_id = object.val();
//alert();
//            console.log(item_total);

//            console.log(item_total);
            if (item_id === "") {
//                alert(1);
                $("input[name='quantity']").val("");
                $("input[name='price']").val("");
                $("input[name='quantity']").prop( "disabled", true );
                $("input[name='price']").prop( "disabled", true );
            } else {
//                alert(2);
//               let max_quantity= object.data('quantity');
//                console.log(max);
                $("input[name='quantity']").prop( "disabled", false );
                $("input[name='price']").prop( "disabled", false );

            }
//            console.log(item_id);
//            $("input[name='item_id']").val("");
//            $("#item_id").val(null).trigger('change');
////            $("input[name='buy_date']").val(today2);
//            $("input[name='quantity']").val("");
//            $("input[name='price']").val("");


        });
        $("body").on("keyup", "#quantity", function (e) {
//alert();
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                // console.log( $(this).next().next());
                $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
//                $(this).next().text("برجاء ادخال ارقام فقط").show().fadeOut(2000);
                return false;
            }
            let object = $("#item_id option:selected");
            let quantity =    $('[name="quantity"]').val();
//            let max_quantity =    $('[name="rest"]').val();
            let max_quantity= object.data('quantity');
            quantity = parseFloat(quantity);
//        money.toFixed(4);
//        console.log(money);
//        console.log(rest);
            if (quantity > max_quantity) {
//                console.log(123);
                quantity = max_quantity;
                $("#quantity").val(quantity);
                $(this).next().text("{{trans('main.quantity_bigger_than_stock_quantity')}}").show().fadeOut(2000);
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