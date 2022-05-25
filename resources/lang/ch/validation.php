<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول :attribute',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
    'confirmed' => 'حقل تاكيد كلمه السر غير مُطابق للحقل :attribute',
    'date' => ':attribute ليس تاريخًا صحيحًا',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists' => 'القيمة المحددة :attribute غير موجودة',
    'file' => 'الـ :attribute يجب أن يكون ملفا.',
    'filled' => ':attribute إجباري',
    'image' => 'يجب أن يكون :attribute صورةً',
    'in' => ':attribute غير صالح',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json' => 'يجب أن يكون :attribute نصآ من نوع JSON.',
    'max' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in' => ':attribute غير صالح',
    'numeric' => 'يجب على :attribute أن يكون رقمًا',
    'present' => 'يجب تقديم :attribute',
    'regex' => 'صيغة :attribute .غير صحيحة',
    'required' => ':attribute مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
    ],
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',

    'ksa_phone' => 'صيغة :attribute .غير صحيحة',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',

        ],


        'video' => [
            'youtube' => 'رابط اليوتيوب غير صالح',

        ],
        'phone' => [
            'uae_phone' => 'رقم الهاتف غير صالح',
            'all_phone' => 'رقم الهاتف غير صالح',

        ],
        'mobile' => [
//            'uae_phone' => 'رقم الهاتف غير صالح',
            'all_phone' => 'رقم الهاتف غير صالح',

        ],
        'email' => [
            'email_check' => 'صيغه الايميل غير صحيحه',
//            'all_phone' => 'رقم الهاتف غير صالح',

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'username' => 'اسم المُستخدم',
        'email' => 'البريد الالكتروني',
        'first_name' => 'الاسم الأول',
        'last_name' => 'اسم العائلة',
        'password' => 'كلمة السر',
        'password_confirmation' => 'تأكيد كلمة السر',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'phone' => 'الهاتف',
        'mobile' => 'الموبايل',
        'age' => 'العمر',
        'sex' => 'الجنس',
        'gender' => 'النوع',
        'day' => 'اليوم',
        'month' => 'الشهر',
        'year' => 'السنة',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'title' => 'العنوان',
        'content' => 'المُحتوى',
        'description' => 'الوصف',
        'excerpt' => 'المُلخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'مُتاح',
        'size' => 'الحجم',
        'text' => 'المحتوي',
        'province' => 'المحافظة',
        'district' => 'الحى',
        'body' => 'النص',
        'video' => 'الفيديو',
        'start_date' => 'تاريخ البداية',
        'end_date' => 'تاريخ الانتهاء',
        'keywords' => 'الكلمات الدلاليه',
        'facebook' => 'الفيسبوك',
        'google' => 'جوجل بلس',
        'twitter' => 'تويتر',
        'linkedin' => 'لينكد ان',
        'pinterest' => 'Pinterest',
        'googleplay' => 'جوجل بلاى',
        'appstore' => 'متجر ابل',
        'start' => 'من',
        'end' => 'الى',
        'full_name' => 'الاسم الكامل',
        'image' => 'الصورة',
        'website_name' => 'اسم الموقع',
        'whatsapp' => 'الواتساب',
        'organization_name' => 'اسم المنشأة',
        'telephone' => 'التليفون',
        'message' => 'نص الرسالة',
        'max_units' => 'اقصى عدد اعلانات',
        'no_of_people' => 'عدد الاستيعاب للاشخاص',
        'today' => 'اليوم',
        'user_name' => 'اسم المستخدم',
        'personal_name' => 'الاسم الشخصى',
        'phone1' => 'رقم التليفون الاول',
        'phone2' => 'رقم التليفون الثانى',
        'type' => 'النوع',
        'details' => 'التفاصيل',

        'client_id' => 'اسم العميل',
        'supplier_id' => 'اسم المورد',
        'project_value' => 'قيمه المشروع',
        'complete_percent' => 'نسبة اكتمال',
        'location' => 'الموقع',
        'client_name' => 'اسم العميل',
        'u_name' => 'الاسم',
        'u_user_name' => 'اسم المستخدم',
        'u_email' => 'الايميل',
        'u_password' => 'كلمه السر',
        'u_password_confirmation' => 'تأكيد كلمة السر',
        'payment_type' => 'طريقة الدفع',
        'amount' => 'المبلغ',
        'check_number' => 'رقم الشيك',
        'item_id' => 'اسم البند',
        'initial_balance' => 'الرصيد الابتدائى',
        'country_id' => 'الدولة',
        'images' => 'الصور',
        'budget' => 'الميزانية',
        'duration' => 'المده',
        'department_id' => 'القسم',
        'district_id' => 'المنطقة',
        'nationality_id' => 'الجنسية',
        'items' => 'مجالات العمل',
        'bio' => 'نبذه',
        'attach_file' => 'ملف مرفق',
        'code' => 'الكود',
        'password_confirm' => 'اعاده كلمه المرور',
        'bank_name' => 'اسم البنك',
        'account_number' => 'رقم الحساب',
        'price' => 'السعر',
        'answer' => 'الاجابه',
        'question_id' => 'السؤال',
        'down_payment' => 'المقدم',
        'sale_date' => 'تاريخ البيع',
        'installment_start_date' => 'تاريخ بدء القسط',
        'months' => 'عدد شهور التقسيط',
        'percentage' => 'الفائده',
        'job' => 'الوظيفة',
        'total_after_percentage' => 'الاجمالى بعد الفائده',
        'receiver_name' => 'اسم المستلم',
        'receiver_phone' => 'تليفون المستلم',
        'receiver_address' => 'عنوان المستلم',
        'order_amount' => 'قيمه الطرد',
        'driver_id' => 'السائق',
        'fee' => 'مصاريف الشحن',
        'money' => 'المبلغ',
        'deliver_driver_id' => 'سائق التسليم',
        'receiver_driver_id' => 'سائق الاستلام',
        'status' => 'الحالة',
        'delivering' => 'جارى التسليم',
        'city_id' => 'المدينة',
//        'email_check' => 'صيغه الايميل غير صحيحه',



    ],
];
