<html>
<head>
<title>LRC 歌词编辑器</title>
<style>
    nav ul {
        position: fixed;
        z-index: 99;
        right: 5%;
        border: 1px solid darkgray;
        border-radius: 5px;
        list-style:none;
        padding: 0;
    }

    .tab {
        padding: 1em;
        display: block;
    }

    .tab:hover {
        cursor: pointer;
        background-color: lightgray !important;
    }

    td {
        padding:0.2em;
    }

    textarea[name="edit_lyric"] {
        width: 100%;
        height: 50em;
    }

    input[type="button"] {
        width: 100%;
        height: 100%;
    }

    input[type="submit"] {
        width: 100%;
        height: 100%;
    }

    #td_submit {
        text-align: center;
    }

    select {
        display: block;
    }

    #lyric {
        width: 35%;
        height: 60%;
        border: 0;
        resize: none;
        font-size: large;
        line-height: 2em;
        text-align: center;
    }
</style>
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">

        var mp3url = "";

        function getURL(node) {
            var mp3URL = "";
            try{
                var file = null;
                if(node.files && node.files[0] ){
                    file = node.files[0];
                }else if(node.files && node.files.item(0)) {
                    file = node.files.item(0);
                }
                try{
                    mp3URL =  file.getAsDataURL();
                }catch(e){
                    mp3RUL = window.URL.createObjectURL(file);
                }
            }catch(e){
                if (node.files && node.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        mp3URL = e.target.result;
                    };
                    reader.readAsDataURL(node.files[0]);
                }
            }

            creatMp3(mp3RUL);
            return mp3URL;
        }

        function creatMp3(mp3URL){   //根据指定URL创建一个Img对象
            var textHtml = "<audio id='audio' src='"+mp3URL+"' controls autoplay/><br/>";
            $(".bgsound").after(textHtml);
        }


        function   saveLyric()
        {
            var   winSave   =   window.open();
            winSave.document.open   ("text/html","utf-8");
            winSave.document.write   (document.getElementById("edit_lyric").value);
            winSave.document.execCommand   ('SaveAs',true,'test.lyric','.lyric');
            winSave.close();
        }

    </script>
</head>
<body>
    <nav><ul>
        <li id="d_edit" class="tab">Edit Lyric</li>
        <li id="d_show" class="tab">Show Lyric</li>
    </ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
<form id="f_upload" enctype="multipart/form-data" method="post" action="lab11.php">
    <p>请上传音乐文件</p>

    <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->

    <input type="file" name="file_upload" accept="audio/*" onchange="getURL(this)">
    <div class="bgsound"></div>
    <table>
        <tr><td>Title: <input type="text" name="title" required></td><td>Artist: <input type="text" name="artist" required></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input type="button" value="插入时间标签" onclick="insertText()"></td><td><input type="button" value="替换时间标签" onclick="changeTime()"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" value="Submit"  ></td></tr>
        <?php
        if (isset($_POST['edit_lyric'])) {
            if ($_FILES['file_upload']['error'] > 0) {
                echo 'Problem: ';
                switch ($_FILES['file_upload']['error']) {
                    case 1:
                        echo 'File exceeded upload_max_filesize.';
                        break;
                    case 2:
                        echo 'File exceeded max_file_size.';
                        break;
                    case 3:
                        echo 'File only particularly uploaded.';
                        break;
                    case 4:
                        echo 'No file uploaded.';
                        break;
                    case 6:
                        echo 'Cannot upload file:No temp directory specified.';
                        break;
                    case 7:
                        echo 'Upload failed :Cannot write to disk.';
                        break;
                    case 8:
                        echo 'A PHP extension blocked the file upload.';
                        break;
                }
                exit;
            }
            //创建一个文件夹
            $path_music=$_SERVER['DOCUMENT_ROOT']."/lab11/music/";
            //判断该用户文件夹是否已经有这个文件夹
            if(!file_exists($path_music)) {
                mkdir($path_music);
            }
            $upload_file = $path_music.$_FILES['file_upload']['name'];
            if (is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
                if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_file)) {
                    echo 'Problem: Could not move file to destination directory.';
                    exit;
                }
            } else {
                echo 'Problem: Possible file upload attack .Filename:';
                echo $_FILES['file_upload']['name'];
                exit;
            }
            echo 'File uploaded successfully.';
            echo 'You have uploaded the following file:' . $_FILES['file_upload']['name'];
        }
        ?>
    </table>
</form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <select>
    <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->
    
    </select>

    <textarea id="lyric" readonly="true">
    </textarea>
    
    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->

</section>
</body>
<script>

// 界面部分
document.getElementById("d_edit").onclick = function () {click_tab("edit");};
document.getElementById("d_show").onclick = function () {click_tab("show");};

document.getElementById("d_show").click();

function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit 部分
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// 获取所在行的初始位置。

function get_target_pos(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let pos = 0;
    for (let i = n_pos; i >= 0; i--) {
        if (value.charAt(i) === '\n') {
            pos = i + 1;
            break;
        }
    }
    return pos;
}

// 选中所在行。
function get_target_line(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let f_pos = get_target_pos(n_pos);
    let l_pos = 0;

    for (let i = f_pos;; i++) {
        if (value.charAt(i) === '\n') {
            l_pos = i + 1;
            break;
        }
    }
    return [f_pos, l_pos];
}

/* HINT: 
 * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
 * 来获取第一个位置，从而插入相应的歌词时间。
 * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
 * selectionEnd 获取相对应的位置。
 *
 * TODO: 请实现你的歌词时间标签插入效果。
 */
var secondsToTime = function( secs )
{
    var hoursDiv = secs / 3600, hours = Math.floor( hoursDiv ), minutesDiv = secs % 3600 / 60, minutes = Math.floor( minutesDiv ), seconds = Math.ceil( secs % 3600 % 60 );
    if( seconds > 59 ) { seconds = 0; minutes = Math.ceil( minutesDiv ); }
    if( minutes > 59 ) { minutes = 0; hours = Math.ceil( hoursDiv ); }
    return ( hours == 0 ? '00:' : hours > 0 && hours.toString().length < 2 ? '0'+hours+':' : hours+':' ) + ( minutes.toString().length < 2 ? '0'+minutes : minutes ) + ':' + ( seconds.toString().length < 2 ? '0'+seconds : seconds );
}

function insertText() {
  let  obj=document.getElementById("edit_lyric");
  if (document.getElementById("audio")) {
      var    music=document.getElementById("audio");
      var time=parseInt(music.currentTime);
      time=secondsToTime(time);
  }

    if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
      var str="["+time+"]";
        var startPos = get_target_pos(obj.selectionStart),
            endPos = get_target_pos(obj.selectionStart),
            cursorPos = startPos,
            tmpStr = obj.value;
        obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
        cursorPos += str.length;
        obj.selectionStart = obj.selectionEnd = cursorPos;
    }
}
function  changeTime() {
    let  obj=document.getElementById("edit_lyric");
    if (document.getElementById("audio")) {
        var    music=document.getElementById("audio");
        var time=parseInt(music.currentTime);
        time=secondsToTime(time);
        if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
            var str="["+time+"]";
            var startPos = get_target_pos(obj.selectionStart),
                endPos = get_target_pos(obj.selectionStart)+10,
                cursorPos = startPos,
                tmpStr = obj.value;
            obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
            cursorPos += str.length;
            obj.selectionStart = obj.selectionEnd = cursorPos;
        }
    }else{
        document.getElementById("edit_lyric").value="请导入音乐文件！";

    }


}

/* TODO: 请实现你的上传功能，需包含一个音乐文件和你写好的歌词文本。
 */

/* HINT: 
 * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
 * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
 * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
 * 当前歌词请以粗体显示。
 * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
 * 词保持在正中。
 *
 * TODO: 请实现你的歌词滚动效果。
 */

</script>
</html>
