@push('script')


    <script>

        var experiences = [];
        var experienceCounter = 0;
        var educations = [];
        var educationCounter = 0;

        $(function () {
            calcAll();
        });
        $(document).on('click', '#add-education', function (e) {
            e.preventDefault();


            let qualification_title = $("input[name='qualification_title']").val();
            let university = $("input[name='university']").val();
            let graduation_year = $("input[name='graduation_year']").val();

//            console.log(item_total);
            if (qualification_title === "" || university === "" || graduation_year === "") {
                return false;
            }
//            console.log(item_id);
            $("input[name='qualification_title']").val("");
            $("input[name='university']").val("");
            $("input[name='graduation_year']").val("");


            let education = {};

            educationCounter += 1;

            education.id = educationCounter;
            education.qualification_title = qualification_title;
            education.university = university;
            education.graduation_year = graduation_year;

//            console.log(item_total);
//            console.log(total);


            educations.push(education);
//            console.log(quantity);
            $(".educations-append-area").prepend(
                `
         <tr class="education-content-row" educationid="${educationCounter}" >
            <td>${educationCounter}</td>
            <td>${qualification_title}</td>
            <td>${university}</td>
            <td>${graduation_year}</td>



            <td class="text-center">

                <button type="button" class="destroy btn btn-danger btn-xs remove-education"><i
                            class="fa fa-trash-o"></i></button>

            </td>
        </tr>
                `
            );

            calcAll();

        });


        $("body").on("click", ".remove-education", function () {

            let educationParentTr = $(this).parents(".education-content-row");

            let id = educationParentTr.attr("educationid");
            id = parseInt(id);
            let index = educations.findIndex(x => x.id === id);

            let education = findObjectByKey(educations, 'id', id);


            calcAll();

            educations.splice(index, 1);


            educationParentTr.remove();


        });


        $(document).on('click', '#add-experience', function (e) {
            e.preventDefault();


            let employer_name = $("input[name='employer_name']").val();
            let from = $("input[name='from']").val();
            let to = $("input[name='to']").val();
            let position = $("input[name='position']").val();
            let working_status = $("input[name='working_status']").val();

//            console.log(item_total);
            if(to===""){
                to="now";
            }
            if (employer_name === "" || from === "" || to === "" || position === "" || working_status === "") {
                return false;
            }
//            console.log(item_id);
            $("input[name='employer_name']").val("");
            $("input[name='from']").val("");
            $("input[name='to']").val("");
            $("input[name='position']").val("");
            $("input[name='working_status']").val("");


            let experience = {};

            experienceCounter += 1;

            experience.id = experienceCounter;
            experience.employer_name = employer_name;
            experience.from = from;
            experience.to = to;
            experience.position = position;
            experience.working_status = working_status;

//            console.log(item_total);
//            console.log(total);


            experiences.push(experience);
//            console.log(quantity);
            $(".experiences-append-area").prepend(
                `
         <tr class="experience-content-row" experienceid="${experienceCounter}" >
            <td>${experienceCounter}</td>
            <td>${employer_name}</td>
            <td>${from}</td>
            <td>${to}</td>
            <td>${position}</td>
            <td>${working_status}</td>



            <td class="text-center">

                <button type="button" class="destroy btn btn-danger btn-xs remove-experience"><i
                            class="fa fa-trash-o"></i></button>

            </td>
        </tr>
                `
            );

            calcAll();

        });


        $("body").on("click", ".remove-experience", function () {

            let experienceParentTr = $(this).parents(".experience-content-row");

            let id = experienceParentTr.attr("experienceid");
            id = parseInt(id);
            let index = experiences.findIndex(x => x.id === id);

            let experience = findObjectByKey(experiences, 'id', id);


            calcAll();

            experiences.splice(index, 1);


            experienceParentTr.remove();


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


            let educationsToSend = JSON.stringify(educations);

            $('input[name="educations"]').val(educationsToSend);


            let experiencesToSend = JSON.stringify(experiences);

            $('input[name="experiences"]').val(experiencesToSend);

        }



    </script>
@endpush