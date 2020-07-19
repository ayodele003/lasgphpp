$(document).ready(function(){
    $.ajax({
        url:"dashboard.php",
        method:"GET",
        success: function(data){
            console.log(data);
            var bank = [];
            var amount = [];

            for(var i in data){
                bank.push("Test" + data[i].bank);
                amount.push(data[i].currentbal);
            }
            
            var chardata = {
                labels:bank,
                datasets: [
                    {
                        label :'Bank Name',
                        backgroundColor: '#ffc107',
                        borderColor: '#ffa12a',
                        hoverBackgroundColor: '#8031a7',
                        hoverBorderColor: '8031a7',
                        data: amount
                    }
                ]
            };
            var ctx = $("#mycanvas");
            var barGraph = new Chart(ctx,{
                type: 'bar',
                data: chardata
            });
        },
        error: function(data){
            console.log(data);
        }
    });
});