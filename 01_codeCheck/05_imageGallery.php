<script>
    var serverScriptUrl = '<?php echo $serverScript; ?>'; // 服务器端处理脚本的URL

    function transferImage(imageUrl) {
        // 提示用户输入密码
        var userPassword = prompt('Please enter the password to transfer the image:');

        // 如果用户取消输入，则退出
        if (!userPassword) {
            alert('Password input canceled.');
            return;
        }

        // 获取图片的文件名
        var imageName = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);

        // 创建 XMLHttpRequest 对象
        var xhr = new XMLHttpRequest();
        xhr.open('POST', serverScriptUrl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        // 设置回调函数，处理服务器端响应
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    if (xhr.responseText === 'success') {
                        alert('Image transfer information recorded successfully!');
                    }
                } else if (xhr.status == 403) { // 处理密码错误的情况
                    if (xhr.responseText.includes('error: incorrect password')) {
                        alert('Incorrect password. Please try again.');
                    }
                } else if (xhr.status == 400) { // 处理 imageName 参数缺失的情况
                    if (xhr.responseText.includes('error: imageName parameter is missing')) {
                        alert('Error: image name is missing.');
                    }
                } else {
                    alert('Error: Unable to record transfer information.');
                }
            }
        };

        // 发送图片名称和用户输入的密码到服务器端进行验证
        xhr.send('imageName=' + encodeURIComponent(imageName) + '&password=' + encodeURIComponent(userPassword));
    }
</script>
