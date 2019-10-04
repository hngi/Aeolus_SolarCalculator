jQuery.fn.exists = function(){ return this.length > 0; }

$(function() {
    function test_number_limits(element) {
        var currentElement = $(element);
        var maxsize = currentElement.attr("max");
        if (maxsize) {
            if (parseInt(currentElement.val()) > parseInt(maxsize)) {
                currentElement.val(maxsize);
            }
        }
    }
    window.onscroll= function() {myFunction()};
var header = document.getElementById("m-header");
var sticky = header.offsetTop;
function myFunction() {
	if(window.pageYOffset > sticky) {
	header.classList.add("sticky");
	}	else	{
		header.classList.remove("sticky");
	}


}

    function update_ultimate_total() {
        var sum = 0;
        $('.total').each(function() {
            currentValue = $(this).text() || 0;
            sum += parseFloat(currentValue);

            if (sum >= 1000000 ) {
                var o = (sum / 1000000).toFixed(2);
                p = o;
                o = o + ' MWh';
            }else if (sum >= 1000) {
                var o = (sum / 1000).toFixed(2);
                p = o;
                o = o + ' kWh';
            } else {
                var o = sum.toFixed(2);
                p = o;
                o = o + ' Wh';
            }

            $('#totalword').html('<strong>'+(o)+'</strong>');
            $('#total_rate').val((sum));
        });
    }

    function calculatations_empty() {
        if ($('input[name^="total"]').val() == "") {
            return true;
        } else {
            return false;
        }
    }

   function generate_email_body_for_load_calc() {
        var html = '';

        if (calculatations_empty()) {
            alert('You did not finish this calculation');
            return;
        }

        $('#tda').find('tbody').children('tr').each(function() {
            if ($(this).find($('.total').text()) != 0) { // ignore empty rows
                html += '<tr>';

                $(this).children('td').each(function() {
                    // If this cell doesn't have anything useful, return
                    if (!$(this).find('span').exists()) {
                        return;
                    }
                    
                    html += '<td style="font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:13px;vertical-align: top;">';
                    if ($(this).find('span').exists()) {
                        html += $(this).find('span').text();
                    }
                    html += '</td>';
                });
                html += '</tr>';
            }
        });

        return html;
    }

    $('#dinam').on('click', 'button', function () {
        var tr = $(this).closest('tr');

        tr.remove();

        var old_sum = parseFloat($('#total_rate').val());
        var removed_sum = parseFloat(tr.find('.total').text());

        var new_sum = old_sum - removed_sum;

        $('#total_rate').val(new_sum);
        sum = 0;
        sum += parseFloat(new_sum);

        if (sum >= 1000000 ) {
            var o = (sum / 1000000).toFixed(2);
            o = o + ' MWh';
        }else if (sum >= 1000) {
            var o = (sum / 1000).toFixed(2);
            o = o + ' kWh';
        } else {
            var o = sum.toFixed(2);
            o = o + ' Wh';
        }

        $('#totalword').html('<strong>'+(o)+'</strong>');
    })

    // Enforce numbers only in number HTML input types
    // Enforce strict compliance to max
    $('input[type="number"]').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        test_number_limits(this);
    });

    $( "form" ).submit(function( e ){
        var fields = $(this).serializeArray();
        
        e.preventDefault();

        var name = fields[0].value;
        var units = fields[1].value || 1;
        var watts = fields[2].value || 0;
        var hrs = fields[3].value || 0;

        var whd = (hrs * watts * units);

        if (name != '' && units != '' && watts != '' & hrs != '') {
            $('#dinam').append(
                '<tr class="d-flex">'+
                '<td class="col-3"><span>'+name+'</span></td>' +
                '<td class="col-2"><span>'+units+'</span></td>' +
                '<td class="col-2"><span>'+watts+'</span></td>' +
                '<td class="col-2"><span>'+hrs+'</span></td>' +
                '<td class="col-2 total"><span>'+whd+'</span></td>' +
                '<td class="col-1"><button class="btn btn-sm btn-danger">DEL</button></td></tr>'
                )
            $("#load-calc").find(':input[type="number"]').val("");
            $("#load-calc").find(':input[type="text"]').val("");
            update_ultimate_total();
        } else {
            alert('Fill in details of your appliance for calculations');
        }

    });

    $("#clearform").click(function() {
        $("#load-calc").find(':input[type="number"]').val("");
        $("#load-calc").find(':input[type="text"]').val("");
    })


    $('#exprcal').click(function(e) {
        // Only export if there is/are data
        if($('#dinam').children().length > 0){
            $('#exampleModal').modal('toggle');
        }else {
            alert('No data entered');

            return;
        }
    })

    $('#send-email').click(function(e) {
        
        e.preventDefault();

        var send_to = $('#mail').val();
        var lead_name = $('#fname').val();

        if (lead_name == "") {
            alert("Please provide your name");
            return;
        } else if (send_to == "") {
            alert("Please provide your email");
            return;
        }

        var email_message = generate_email_body_for_load_calc();

        var data = {
            to: send_to,
            name: lead_name,
            message: email_message,
            wattage: $('#totalword').text(),
            pub_api: "FaFTahhYT245TY0--=6tDEahjIIoP_juAD"
        };

        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/export.php',
            data: data
        }).always(function(data) {
            if (data.result == true) {
                alert('Email successfully sent.');
            } else {
                alert('Error sending email');
            }
        });
    });
});

