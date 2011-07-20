<?php

function getheader(){
    
    echo<<<E_O_T
    <div class="globalheader" id="gl">
        <div class="globalheaderwrapper"> 
                    <div class="controlpanel">
                            <a href="../home">Home</a>
                            |
                            <a href="../home/editprofile.php">Edit Profile</a>
                            |
                            <a href="../home/editphotos.php">Edit Photos</a>
                            |
                            <a href="../home/editgroups.php">Edit Groups</a>
                            |
                            <a href="../logout.php">Logout</a>   
                    </div>
                    <div class="globalheadermain">
                                <div class="globalheaderhome">
                                <a href="../home"><img src="../images/img_headerlogo.png"></img></a>
                                </div>
                                <div class="globalheadersearch"> 
                                <form action="../home/search.php" method="GET" id="searchform">
                                <table>
                                    <tr>
                                        <td>
                                        <div class="inputwrapper">
                                        <input type="text" name="key" id="searchbox" />
                                        </div>
                                        </td>
                                        <td>
                                        <div class="searchbutton">
                                        <input type="submit" class="btn_search"  id="btn_search" value="">
                                        </div>
                                        </td>
                                     </tr>
                                </table>
                                </form>
                                </div>
                    </div>
       </div>
    </div>
E_O_T
;

}
?>
