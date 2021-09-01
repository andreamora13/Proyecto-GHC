$.ajax({
            url:'{{ action('ProController@grafica2')}}',
           
            success: function(data) {
               var semana=data[0];
               var agua=data[1];
               var agua_r=data[2];
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                         data: {

                        labels: semana,
                        datasets: [{
                            label: 'agua',
                            data: agua,
                            backgroundColor: [
                                'rgba(255,255, 255, 0.2)'
                            ],
                            borderColor: [
                                 'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'agua_r',
                            data:agua_r,
                            backgroundColor: [
                                'rgba(255,255, 255, 0.2)'
                            ],
                            borderColor: [
                                 'rgba(30, 144, 255, 1)'
                            ],
                            borderWidth: 1
                        }
                        
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                    });
                                     
                 },
                                
            }
    );
