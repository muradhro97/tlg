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
//            alert();


            let item_name = $("#item_id option:selected").text();
            let item_id = $("#item_id option:selected").val();
            let price = $("input[name='price2']").val();
            let quantity = $("input[name='quantity']").val();
            let item_total = price * quantity;
//            alert(price);
//            console.log( $("input[name='quantity']"));
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
            $("input[name='price2']").val("");
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

        $(function () {
            let $itemsJs = {!! $itemsJs !!};
            $.each($itemsJs, function (index, value) {

                let item_id = value.item_id;
                let item_name = value.item_name;
                let quantity = value.quantity;
                let price = value.price;
                let item_total = value.price * value.quantity;

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

        });

    </script>
@endpush