
  
<!--Create Ticker : Alert --> 
    <!--It will be generating from users joined within last 2 days and joined groups -->
    <?php 
        
      //  $alert=""; // Alert String  : for now it shows the info about joined users and group
//        $joinedUsers=User::findByJoinedDate(Config::get('alert.look_back_days'));        
//         
//        if (sizeof($joinedUsers)>0){ 
//            if (sizeof($joinedUsers)<Config::get('alert.maximum_people')){
//                $alert.=sizeof($joinedUsers)." people joined within ".Config::get('alert.look_back_days')." days";
//            }
//            else{           
//                $alert.=$joinedUsers[0]->first_name." ".$joinedUsers[0]->last_name.", "
//                .$joinedUsers[1]->first_name." ".$joinedUsers[1]->last_name.", ";
//                
//                $alert.=(sizeof($joinedUsers)-Config::get('alert.maximum_people')) +1 
//                ." other people joined within ". Config::get('alert.look_back_days'). " days";
//            }
//        }
//        
//        
//        
// find by gropus
//        $joinedCircleUsers=CircleUser::findByJoinedDate(Config::get('alert.look_back_days'));
//        
//        if (sizeof($joinedCircleUsers)>0){
//            $alert.=" and ";
//            if (sizeof($joinedCircleUsers)<Config::get('alert.maximum_people')){
//                $alert.=sizeof($joinedCircleUsers)." people joined at group within ".Config::get('alert.look_back_days')." days";
//            }
//            else{     
//             
//                $firstUser=User::find($joinedCircleUsers[0]->user_id);
//                $secondUser=User::find($joinedCircleUsers[1]->user_id);
//                     
//                $alert.=$firstUser->first_name." ".$firstUser->last_name.", "
//                .$$secondUser->first_name." ".$secondUser->last_name.", ";
//                
//                $alert.=(sizeof($joinedCircleUsers)-Config::get('alert.maximum_people')) +1 
//                ." other people joined at group within ". Config::get('alert.look_back_days'). " days";
//            }    
//        } 

       
       $alerts=array(); // Alert String  : for now it shows the info about joined users and group
       $joinedUsers=User::findByJoinedDate(Config::get('alert.look_back_days'));        
       
       foreach($joinedUsers as $user) {       
           $alerts[]=$user->first_name." ".$user->last_name." joined Lead Cliq";
       }
       
        // find by gropus

       $circlesWithRecent =Circle::withRecentUsers(Config::get('alert.look_back_days'));
       
       foreach($circlesWithRecent as $circle) {
                   
           $users = $circle->users;

           foreach ($users as $user){
               if ($user->id !== Sentry::getUser()->id)
               $alerts[]=$user->first_name." ".$user->last_name." joined at circle ".$circle->name;

           }

       }
       
        $index=0;                 
    ?> 
    
    <script>
        var alertCount={{sizeof($alerts)}};
    </script>
    
    <div class="ticker-container" style="padding:5px;color:white;background-color:#555;border-top: 4px solid #F66C06;">
        
        @foreach ($alerts as $alert)
        
        <div class="ticker" data-delay="<?php echo $index; ?>" >            
            {{$alert}}
        </div>    
        
          <?php 
            $index++;
        ?>
        @endforeach
       
    </div>
