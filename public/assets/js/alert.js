    
    var screenWidth=$( window ).width();              
    
    var phase_1 = {
          top    : 0,
          left   : screenWidth,
          position: 'absolute',
          opacity : 0
    };

    var phase_2= {
          top    : 0,
          left   : screenWidth*0.8,              
          position: 'absolute',
          opacity : 1.0
          
    };
    
    var phase_3= {
          top    : 0,
          left   : screenWidth*0.1,
          position: 'absolute',
          opacity : 1.0
    };
    
    var phase_4= {
          top    : 0,
          left   : 0,
          position: 'absolute',
          opacity : 0.0
    };

     var StartFunc;   
       
    // Bind the resize event. When the window size changes, update its corresponding
    
    // info div.
    
    
  
     jQuery("div.ticker").ready(function( $ ){
           
         StartFunc=function start(){
             
             jQuery( "div.ticker" ).each(
                function(){
                    $(this).delay(10000*$(this).attr('data-delay'))
                    .css(phase_1)
                    .animate(
                            phase_2,2000
                    ).delay(1000)
                    .animate(
                            phase_3,5000
                    ).delay(1000)
                    .animate(
                        phase_4,2000
                    )
                    .delay(10000*(alertCount-1)-10000*$(this).attr('data-delay'))
                    .animate(
                        phase_4,0,'linear',function(){start();}
                    );         
                }
             );
                
         } 
         
         StartFunc();
      
    });
  

// Resize function : reset the width

    jQuery(window).resize(function(){
        //update screenWidth
        screenWidth=$( window ).width();
        phase_1.left=screenWidth;
        phase_2.left=screenWidth*0.8;
        phase_3.left=screenWidth*0.1;
         StartFunc();     
    });
    