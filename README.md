# Laravel10 Api Starter

基于Laravel 10构建的一个**基础功能**完备，**规范统一**，能够**快速**应用于实际的 API 项目开发启动模板。同时，也希望通过**合理的**架构设计使其适用于中大型项目。

可以简单的API版本，目录形式，在api.php里面可以看到

开箱即用，加速 Api 开发。


## 概览

### 说明

项目就平时自己使用的，分享出来，不一定很好，勿喷，预装了dcatadmin，不需要的可以卸载。
会laravel基本都会使用，好记性不如烂笔头，比较习惯记录下来：
- 修改.env数据库连接信息
- composer install
- php artisan migrate
- 创建测试的用户：php artisan db:seed --class=UsersTableSeeder
- php artisan storage:link

API登录获取access token：
https://xxx.com/api/v1/auth/login

拿到access token后
在头部Header里面增加：
Authorization: bearer (这里填写上面获取到的access_token)

https://xxx.com/api/v1/auth/me


### 支持情况

- RESTful 规范的HTTP 响应结构：成功、失败、异常场景统一结构响应；多语言提示返回
- Jwt-auth 方式授权


### 目录结构

```
├── app
│   ├── Console
│   │   ├── Commands                  // cli command：通常用于实现轮询任务
│   │   └── Kernel.php                // Schedule 调度
│   ├── Contracts                     // 定义 interface
│   ├── Api                        // 事件处理
│   │   ├── V1
│           └──Controllers         //Api都写在这里面
                 └──  AuthController.php   // 包含 用户登录和获取用户信息的使用示例
│   ├── Http
│   │   ├── Controllers               // Controller 层根据 Request 将任务分发给不同 Service 处理，返回响应给客户端
│   │   │   └── Controller.php
│   │   ├── Middleware
│   │   │   └── RefreshToken.php      // 自动刷新token
│   │   └── Helpers                  //一些平时自己使用的工具，如rabbit延迟队列，redis锁，加密解密等
│   │       └── ApiResponse.php      // API的响应封装在这里面
│   ├── Jobs                          // 异步任务
│   │   ├── ExampleJob.php
│   │   └── Job.php
│   ├── Listeners                     // 监听事件处理
│   │   └── ExampleListener.php
│   ├── Models                        // Laravel 原始的 Eloquent\Model：定义数据表特性、数据表之间的关联关系等；不处理业务
│   │   └── User.php
│   ├── Providers                     // 各种服务容器
│   │   └── AppServiceProvider.php
│   ├── Services                      // Service 层：处理实际业务；调用 Model 取资源数据，分发 Job、Eevent 等
│   │   └── UserService.php
│   └── Support                       // 对框架的扩展，或者实际项目中需要封装一些与业务无关的通用功能集
│       ├── Traits
│       │   ├── Helpers.php           // Class 中常用的辅助功能集
│       │   └── SerializeDate.php
│       └── helpers.php               // 全局会用到的辅助函数
├── rseources
│   └── lang  多语言的api返回都在这个下面
```


## 参考推荐

* [RESTful API 最佳实践](https://learnku.com/articles/13797/restful-api-best-practice)
* [RESTful 服务最佳实践](https://www.cnblogs.com/jaxu/p/7908111.html)
* [Laravel Api Starter](https://github.com/jiannei/laravel-api-starter)
* [jiannei/laravel-response](https://github.com/jiannei/laravel-response)：规范统一的响应数据格式
* [jiannei/laravel-enum](https://github.com/jiannei/laravel-enum)：多语言的枚举支持

## License

The Laravel10 Api Starter is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
