1、创建 socket 文件夹

2、进入socket cd /home/www/yoka/socket/

3、执行：git clone https://github.com/lixuancn/MeepoPS.git

如果报错：
The program 'git' is currently not installed. You can install it by typing:
apt install git

则先执行：apt install git

再执行：git clone https://github.com/lixuancn/MeepoPS.git

4、安装成功后：
- 开启：sudo php demo-telnet.php start
- 关闭：sudo php demo-telnet.php kill