<!doctype html>
<?php
require_once '../check_autherize.php';
require_once '../db.class.php';
require_once '../config.php';
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
$result = DB::query("SELECT *,(select name from tb_cards where id=tb_members.tb_cards_id) as card_name FROM tb_members WHERE tb_cards_id=%d", $_GET['card_id']);
$user = DB::queryFirstRow("SELECT * FROM users WHERE user_token=%s", $_GET['user_token']);
$module = DB::queryFirstRow("SELECT tb_members_id FROM tb_users_module WHERE users_id=%d and tb_cards_id=%d", $user['id'],$_GET['card_id']);
$member =  DB::queryFirstRow("SELECT * FROM tb_members WHERE id=%d", $_GET['member_id']);
$files =  DB::query("SELECT * FROM tb_download WHERE tb_cards_id=%d", $_GET['card_id']);


function get_all_get()
{
        $output = "?"; 
        $firstRun = true; 
        foreach($_GET as $key=>$val) { 
        if($key != $parameter) { 
            if(!$firstRun) { 
                $output .= "&"; 
            } else { 
                $firstRun = false; 
            } 
            $output .= $key."=".$val;
         } 
    } 

    return $output;
} 
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
   



    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="assets/css/customcss.css?v=<?php echo date("YmdHis");?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .list-group-item{
            font-size:20px;
        }
        .icon{
           font-size:30px; 
           margin-right:20px;
        }
        .fa-file-pdf{
            color:red;
        }
        .fa-file-archive{
            color:gray;
        }
        .fa-file-image{
            color: royalblue;
        }

        .fa-download{
            float:right;
            font-size:30px;
        }
    </style>

</head>
<body>
    <div class="page_dowload" >
        <div class="actaionBar" style="color: #fff;">
            <i id="back_to_app" class="fa-solid fa-chevron-left" style="font-size: 25px;width: 50px;height: 25px;color:white;position: absolute;left: 20px;top: 5px;"></i> 
            <div class="title">
                <h4>Download</h4>
            </div>
        </div>
        
        
        <div class="content" >
            <div class="container">
            <ul class="list-group">
                <?php foreach($files as $key=>$row){?>
            <li class="list-group-item">
            <?php
                $fileExtensionIcons = [
                    "pdf" => '<i class="fa-solid fa-file-pdf icon"></i>',
                    "csv" => '<i class="fa-solid fa-file-csv icon"></i>',
                    "xls" => '<i class="fa-solid fa-file-excel icon"></i>',
                    "xlsx" => '<i class="fa-solid fa-file-excel icon"></i>',
                    "zip" => '<i class="fas fa-file-archive icon"></i>',
                    "jpg" => '<i class="fas fa-file-image icon"></i>',
                    "png" => '<i class="fas fa-file-image icon"></i>',
                ];
                $ext = strtolower($row['ext']); 
                if (isset($fileExtensionIcons[$ext])) {
                    echo $fileExtensionIcons[$ext];
                } else {
                    echo '<i class="fas fa-file icon"></i>';
                }
                ?>
                <?php echo $row['filename'];?>

                <i class="fa-solid fa-download download" filename="<?php echo $row['filename'];?>" file="https://admin.anycardx.com/<?php echo $row['file'];?>"></i>
            <!-- <span class="badge badge-info download badge-pill">Download</span> -->
        </li>
        <?php }?>
           
            </ul>
                <!-- <p style="width:100%;margin-top:100px;text-align:center;color:red;">ยังไม่มีข้อมูล</p> -->
                <!-- <div class="col-xs-6 col-sm-6">
                    
                    <div class="box-dowload doc-dowload">
                        <img src="assets/img/icon_doc.svg" >
                        <div style="height: 15px;"></div>
                        <p>เอกสารเรียน</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 ">
                    <div class="box-dowload cer-dowload"> 
                        <img src="assets/img/icon_doc.svg" >
                        <div style="height: 15px;"></div>
                        <p>
                            ประกาศนียบัตร
                        </p>
                    </div>
                </div> -->
            </div>
        </div>
       
       
    </div>

    <div class="page_doc_list" style="display: none;">
        <div class="actaionBar" style="color: #fff;">
            <span class="glyphicon glyphicon-chevron-left icon-back-doc" aria-hidden="true"></span>
            <div class="title">
                <h4>เอกสารเรียน</h4>
            </div>
        </div>
        
        
        <div class="content" >
           <div class="list-card-doc">
                <div class="box-card">
                    <div>
                        The Secret of Storytelling 2023  ศาสต์การเล่าเรื่อง อย่างมืออาชีพ
                    </div>
                    <div class="row footer-card-download">
                        <div class="col-xs-5 col-sm-6" style="padding-top: 25px">
                                <p>25-01-2023 09:51</p>
                        </div>
                        <div class="col-xs-4 col-sm-6" style="padding-top: 25px">
                            
                                <img src="assets/img/icon-pdf.svg" >
        
                                <span>.pdf</span>
                            
                        </div>
                        <div class="col-xs-2 col-sm-6 " style="padding-top: 10px;">
                          
                                <img src="assets/img/icon_dowload.svg" class="appDownload">
                            
                        </div>
                    </div>
                </div>
                <br>
                <div class="box-card">
                    <div>
                        The Secret of Storytelling 2023  ศาสต์การเล่าเรื่อง อย่างมืออาชีพ
                    </div>
                    <div class="row footer-card-download">
                        <div class="col-xs-5 col-sm-6" style="padding-top: 25px">
                                <p>25-01-2023 09:51</p>
                        </div>
                        <div class="col-xs-4 col-sm-6" style="padding-top: 25px">
                            
                                <img src="assets/img/icon-excel.svg" >
        
                                <span>.excel</span>
                            
                        </div>
                        <div class="col-xs-2 col-sm-6 " style="padding-top: 10px;">
                          
                                <img src="assets/img/icon_dowload.svg" >
                            
                        </div>
                    </div>
                </div>
                <br>
                <div class="box-card">
                    <div>
                        The Secret of Storytelling 2023  ศาสต์การเล่าเรื่อง อย่างมืออาชีพ
                    </div>
                    <div class="row footer-card-download">
                        <div class="col-xs-5 col-sm-6" style="padding-top: 25px">
                                <p>25-01-2023 09:51</p>
                        </div>
                        <div class="col-xs-4 col-sm-6" style="padding-top: 25px">
                            
                                <img src="assets/img/icon-ppt.svg" >
        
                                <span>.ppt</span>
                            
                        </div>
                        <div class="col-xs-2 col-sm-6 " style="padding-top: 10px;">
                          
                                <img src="assets/img/icon_dowload.svg" >
                            
                        </div>
                    </div>
                </div>
           </div>
        </div>
       
       
    </div>
 
    <div class="page_cer_list" style="display: none;">
        <div class="actaionBar" style="color: #fff;">
            <span class="glyphicon glyphicon-chevron-left icon-back-cer" aria-hidden="true"></span>
            <div class="title">
                <h4>ใบประกาศนียบัตร</h4>
            </div>
        </div>
        
        
        <div class="content" >
            <div class="cer-box">
                <h4>ใบประกาศนียบัตร</h4>
                <h4 class="title-cer">หลักสูตร ToPCATS รุ่นที่ 12</h4>
                <div style="height: 15px;"></div>
                <img src="assets/img/img_cer.png">
                <div style="height: 20px;"></div>
                <div class="button-defutl bg-yenlow">
                    DOWNLOD
                </div>

            </div>


           
        </div>
       
       
    </div>

    
<script>


    $(function () {
        $(".download").on("click",function(){
            var message = {action: "appDownload",filename:$(this).attr("filename"),file:$(this).attr("file")};
            webkit.messageHandlers.cordova_iab.postMessage(JSON.stringify(message));
        })
        // $(".download").on("click", function(event) {
        //     event.preventDefault();
        //     var filename = $(this).attr("filename");
        //     var fileUrl = $(this).attr("file");
            
        //     var a = document.createElement("a");
        //     a.href = fileUrl;
        //     a.download = filename;
        //     a.target = "_blank";

        //     document.body.appendChild(a);
        //     a.click();
        //     document.body.removeChild(a);
            
        //     var message = {
        //         action: "appDownload",
        //         filename: filename,
        //         file: fileUrl
        //     };
            
        //     webkit.messageHandlers.cordova_iab.postMessage(JSON.stringify(message));
        // });




        $( ".doc-dowload" ).click(function() {
            $(".page_doc_list").show();
            $(".page_dowload").hide();
        });

        $( ".cer-dowload" ).click(function() {
            $(".page_cer_list").show();
            $(".page_dowload").hide();
        });

        $( ".icon-back-doc" ).click(function() {
            $(".page_doc_list").hide();
            $(".page_dowload").show();
        });

        $( ".icon-back-cer" ).click(function() {
            $(".page_cer_list").hide();
            $(".page_dowload").show();
        });
        
    });
              
</script>

<script>
    $(function(){
  $("#back_to_app").on("click",function(){
      var message = {action: "backToApp"};
          webkit.messageHandlers.cordova_iab.postMessage(JSON.stringify(message));
  })
})
  </script>
    </body>
</html>