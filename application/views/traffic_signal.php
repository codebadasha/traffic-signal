<?php
$record =  $records[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Signal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .signal{
            width: 100px;
            height: 100px;
            background: gray;
            border-radius: 50%;
            margin: 20px;
        }
        .signal-cotainer{
            display: flex;
            justify-content: space-around;
        }
        .red{
            background-color: red !important;
        }
        .yellow{
            background-color: yellow !important;
        }
        .green{
            background-color: green !important;
        }
    </style>
</head>
<body>
   <div class="container mt-5 px-3">
        <div class="card">
            <div class="card-header">
                Traffic Signal
            </div>
            <div class="card-body">
                <div class="signal-cotainer mb-5">
                    
                    <div class="form-group">
                        <div id="A" class="signal"></div>
                        <label for="siganalA ">Signal A</label>
                        <input type="number" class="form-control" id="siganalA" data-id='A' class="signal-input" name="signelIndex[]" value="<?php echo $record['signal_a'] ? $record['signal_a'] : 1; ?>"placeholder="siganal A">
                    </div>
                  
                    <div class="form-group">
                        <div id="B" class="signal"></div>
                        <label for="siganalB">Signal B</label>
                        <input type="number" class="form-control" id="siganalB" data-id='B'  class="signal-input" name="signelIndex[]" value="<?php echo $record['signal_b'] ? $record['signal_b'] : 2; ?>" placeholder="siganal B">
                    </div>
                    <div class="form-group">
                        <div id='C' class="signal"></div>  
                        <label for="siganalA">Signal C</label>
                        <input type="number" class="form-control" id="siganalC" data-id='C'  class="signal-input" name="signelIndex[]" value="<?php echo $record['signal_c'] ? $record['signal_c'] : 3; ?>" placeholder="siganal C">
                    </div>
                    <div class="form-group">
                        <div id='D' class="signal"></div>
                        <label for="siganalA">Signal D</label>
                        <input type="number" class="form-control" id="siganalD" data-id='D'  class="signal-input" name="signelIndex[]" value="<?php echo $record['signal_d'] ? $record['signal_d'] : 4; ?>" placeholder="siganal D">
                    </div>
                </div>
                <div class="form-group row px-5 mb-3">
                    <label for="greensignalinterval">Green Signal Interval:-(In Seconds)</label>
                    <input type="number" class="form-control" id="greensignalinterval" value="<?php echo $record['green_signal_interval'] ? $record['green_signal_interval'] : 10; ?>" class="signal-input" name="greensignalinterval"  placeholder="Green Signal Interval">
                </div>
                <div class="form-group row px-5 my-2">
                    <label for="yellowignalinterval">Yellow Signal Interval:-(In Seconds)</label>
                    <input type="number" class="form-control" id="yellowsignalinterval" class="signal-input" name="yellowsignalinterval" value="<?php echo $record['yellow_signal_interval'] ? $record['yellow_signal_interval'] : 3; ?>" placeholder="Yellow Signal Interval">
                </div>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-success" id='startsignal'>Start</button>
                    <button type="button" class="btn btn-danger" id='stopsignal'>Stop</button>
                </div>
            </div>
        </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script>
    $(document).ready(function(){

        let timeoutIds = [];
        $('#startsignal').click(function()
        {
            let is_Duplicate = false;
            let is_SignalIndexVal = false;
            let signalIndex =[];

            $('input[name="signelIndex[]"]').each(function(){
                let val = $(this).val();
                if (signalIndex.includes(val)) {
                    is_Duplicate =true;
                    return;
                } 
                signalIndex.push(val);

                if(val < 1 || val > 4){
                    is_SignalIndexVal = true;
                    return;
                }
            });

            if (is_Duplicate) {
                alert('Same Sequecne Number Not Allowed to Signal')
            } else if(is_SignalIndexVal){
                alert('Signal Sequecne  Between 1 to 4')
            }else{
                let greenInterval = $('#greensignalinterval').val();
                let yellowInterval = $('#yellowsignalinterval').val();
                if (greenInterval < 10 ) {
                    alert('set Green Signal Interval minmum 10s',greenInterval)
                }else if(yellowInterval < 3){
                    alert('set Yellow Signal Interval minmum 3s')
                }else{
                    $.ajax({
                        type:"POST",
                        url:"<?= base_url('TrafficSignal/start_signal')?>",
                        data:{
                            greenInterval:greenInterval,
                            yellowInterval:yellowInterval,
                            signalIndex:signalIndex
                        },
                        success: function(response){
                            
                            var data = JSON.parse(response);
                            if(data.status == '1'){
                                startTrafficSignal(data.greenInterval,data.yellowInterval,data.signalIndex)

                            }else{
                                alert('Somethin Worng, Please try again')
                            }
                        },
                        error: function(){
                            alert('Somethin Worng, Please try again')
                        }

                    });
                }
            }
        });

        $('#stopsignal').click(function(){

            $.ajax({
                type:"POST",
                url:"<?= base_url('TrafficSignal/stop_signal')?>",
                success: function(response){
                    console.log(response);
                    var data = JSON.parse(response);
                    if(data.status == '1'){
                        timeoutIds.forEach(clearTimeout);
                        timeoutIds = [];
                        $('.signal').removeClass('green yellow red');
                        alert('Signal Stop')
                    }else{
                        alert('Somethin Worng, Please try again')
                    }
                },
                error: function(){
                    alert('Somethin Worng, Please try again')
                }

            });
            
        });

        
        function startTrafficSignal(greenInterval,yellowInterval,signalIndex){
            let index = 0;
            const totalSignals = signalIndex.length;

            function ChnageSignal(){

                $('.signal').addClass('red');

                let signalSequecne = [1,2,3,4];
                let currentSignal = signalSequecne[index];
                let targetSiganl = null;


                $('input[name="signelIndex[]"]').each(function(){
                    let val = $(this).val();
                    console.log(val,'=>', currentSignal)
                    if($(this).val() == currentSignal){
                        targetSiganl = $(this).data('id');
                        return false;
                    }
                });
console.log(targetSiganl)
                if(targetSiganl){
                    $('#' + targetSiganl).addClass('green');

                let greenTimeout = setTimeout(function(){
                        $('#' + targetSiganl).removeClass('green').addClass('yellow');
                        
                        let yellowTimeout = setTimeout(function(){
                            $('#' + targetSiganl).removeClass('yellow').addClass('red');
                            index =(index + 1 ) % totalSignals; 
                            ChnageSignal();
                        }, yellowInterval * 1000)

                        timeoutIds.push(yellowTimeout)
                    }, greenInterval * 1000)

                    timeoutIds.push(greenTimeout)
                }
            }

            ChnageSignal();
        }

    });
   </script>
</body>
</html>