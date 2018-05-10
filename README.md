# WxaBlog-Backend

#### 项目介绍（introduction）
WxaBlog（一款极简微信小程序 Blog 开源项目） 后端API和后台管理 [=>戳这里看 WxaBlog 小程序前端](https://gitee.com/node_study/WxaBlog-Frontend)
#### 项目截图（snapshot）
**后台部分**
1. 文章创作： 
 
![文章创作](https://gitee.com/uploads/images/2018/0509/092153_dd35f4b6_1174423.png "屏幕截图.png")

2. 文章查看：  
 
![文章查看](https://gitee.com/uploads/images/2018/0509/092311_f0ca44a3_1174423.png "屏幕截图.png")

**小程序部分**  

1. 首页：   

![小程序首页](https://gitee.com/uploads/images/2018/0509/092418_2699eba8_1174423.png "屏幕截图.png")

2. 文章详情：  

![文章详情](https://gitee.com/uploads/images/2018/0509/092502_d2a4ee57_1174423.png "屏幕截图.png")

#### 快速开始（quick start）
1. `git clone https://gitee.com/node_study/WxaBlog-Backend.git`
2. `cd WxaBlog-Backend`
3. `composer install`, composer 工具没法安装？[=>戳这里](https://wenda.shukaiming.com/article/57)，composer package 安装蜗牛慢？[=>戳这里](https://wenda.shukaiming.com/article/59)
4. 上一步安装好了 composer package 之后会在当前目录生成 `.env` 环境变量配置文件，对 `.env` 文件进行修改，修改为你自己的实际环境配置：
![修改 .env 文件](https://gitee.com/uploads/images/2018/0509/081122_e39b23cc_1174423.png "屏幕截图.png")
以及小程序的 AppId和 AppSecret：
![小程序配置](https://gitee.com/uploads/images/2018/0509/222449_97afc081_1174423.png "屏幕截图.png")

5. 手动创建一个数据库，例如 wxa_blog , 然后选中这个数据库（wxa_blog）执行 WxaBlog-Backend 目录下面的 `sql/wxa_blog.sql`即可创建表和初始数据

6. 将 php 可执行文件所在路径加入到 PATH 环境变量，然后在 WxaBlog-Backend 打开命令行终端，执行`php -S 127.0.0.1:7001 -t public`即可启用后端服务
7. 上一步的`127.0.0.1:7001`必须跟小程序的保持一致
8. 若你想在局域网上使用（手机上预览），请在 nginx 上加一个 proxy_pass 转发请求，例如：
```
    server {
		listen 8001;
		server_name localhost;
		location /{
				proxy_pass http://127.0.0.1:7001;
		}

	}	    
```
开发阶段请务必在微信开发者工具中选中“不校验合法域名、web-view（业务域名）、TLS版本及HTTPS证书”，截图如下：
![开发环境不校验接口安全](https://gitee.com/uploads/images/2018/0509/100523_a1c07120_1174423.png "屏幕截图.png")
#### 注意事项（tips）
1. 数据库依赖 MySQL>=5.5
2. 缓存依赖 Redis>=3.0
3. PHP>=7.2

#### 常见问题(FAQ)
1. 上线到 linux 环境后发现 502 错误，大部分情况下是因为项目目录权限不正确导致的，处理如下：
```
sudo chmod -R 0777 bootstrap/cache
sudo chmod -R 0777 storage
```
若还是报错，请依次查看nginx & php & Laravel 的 error log


# MyTestSmallProgramBack
