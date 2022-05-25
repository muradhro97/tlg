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
            let price = $("#item_id option:selected").data('price');
            console.log(price)
            let quantity = $("input[name='quantity']").val();
            let exchange_ratio = $("input[name='exchange_ratio']").val();
            let item_total = price * quantity * exchange_ratio/100;
//            console.log(item_total);
            item_total = item_total.toFixed(4);
//            console.log(item_total);
            if (item_id === "" || price === "" || quantity === ""  || exchange_ratio === "") {
                return false;
            }
//            console.log(item_id);
            $("input[name='item_id']").val("");
            $("#item_id").val(null).trigger('change');
//            $("input[name='buy_date']").val(today2);
            $("input[name='quantity']").val("");
            $("input[name='price']").val("");
            $("input[name='exchange_ratio']").val("");
//            let index = items.findIndex(x => x.item_id === item_id);
            let item = {};

            counter += 1;

            item.id = counter;
            item.item_id = item_id;
            item.item_name = item_name;
            item.quantity = quantity;
            item.price = price;
            item.exchange_ratio = exchange_ratio;
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
            <td>${exchange_ratio}</td>
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

        $(document).on('click', '#add-item_minus', function (e) {
            e.preventDefault();


            let item_name = $("#item_id_minus option:selected").text();
            let item_id = $("#item_id_minus option:selected").val();
            let price = $("input[name='price_minus']").val();
            let item_total = -price;
//            console.log(item_total);
            item_total = item_total.toFixed(4);
//            console.log(item_total);
            if (item_id === "" || price === "" ) {
                return false;
            }
//            console.log(item_id);
            $("input[name='item_id_minus']").val("");
            $("#item_id_minus").val(null).trigger('change');
//            $("input[name='buy_date']").val(today2);
            $("input[name='price_minus']").val("");
//            let index = items.findIndex(x => x.item_id === item_id);
            let item = {};

            counter += 1;

            item.id = counter;
            item.item_id = item_id;
            item.item_name = item_name;
            item.price = -price;
            item.quantity = null;
            item.exchange_ratio = null;
            item.total = item_total;
//            console.log(item_total);
//            console.log(total);
            total = parseFloat(total) + parseFloat(item_total);

            items.push(item);
//            console.log(quantity);
            $(".item-append-area").append(
                `
         <tr class="sec-content-row" style="border: 2px dashed #d72323;" itemid="${counter}" >
            <!--<td>${counter}</td>-->
            <td>${item_name}</td>
            <td>---</td>
            <td>${-price}</td>
            <td>---</td>
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



    </script>
@endpush
