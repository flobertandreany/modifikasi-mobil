// Fungsi untuk menampilkan popup register berhasil
function showSuccessRegisterAlert() {
    Swal.fire({
        icon: 'success',
        title: 'Thank You For Your Registration!',
        text: 'Thank you for registering your shop on our website. Please check your email within 1-2 days to find out the status of the store',
        confirmButtonText: 'Back',
        confirmButtonColor: '#F36600',
    }).then((result) => {
        window.location.href = '/login';
    });
}

function loadDataSelectAddress(){
    $('#store_province').change(function() {
        var provinceId = $(this).val();
        //Reset options
        $('#store_city').empty().append('<option value="">Select City</option>');
        $('#store_district').empty().append('<option value="">Select District</option>');
        $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

        if (provinceId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "/store/city",
                method: 'GET',
                dataType: 'json',
                data: {
                    id: provinceId,
                },
                success: function(data) {
                    data.forEach(function(city) {
                        $('#store_city').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                }
            });
        }
    });

    $('#store_city').change(function() {
        var cityId = $(this).val();
        //Reset options
        $('#store_district').empty().append('<option value="">Select District</option>');
        $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

        if (cityId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "/store/district",
                method: 'GET',
                dataType: 'json',
                data: {
                    id: cityId,
                },
                success: function(data) {
                    data.forEach(function(district) {
                        $('#store_district').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                }
            });
        }
    });

    $('#store_district').change(function() {
        var districtId = $(this).val();
        //Reset options
        $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

        if (districtId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "/store/subdistrict",
                method: 'GET',
                dataType: 'json',
                data: {
                    id: districtId,
                },
                success: function(data) {
                    data.forEach(function(subdistrict) {
                        $('#store_subdistrict').append('<option value="' + subdistrict.id + '">' + subdistrict.name + '</option>');
                    });
                }
            });
        }
    });
}
