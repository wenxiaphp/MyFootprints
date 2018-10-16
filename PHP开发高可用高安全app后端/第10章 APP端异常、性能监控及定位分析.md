# APP端异常、性能监控及定位分析

开发中遇到bug是每个小伙伴们最头疼的问题，那么我们如何去监控、排查、定位进而去解决bug呢？本章先带领大家分析APP端异常等业务，然后讲解异常以及性能数据收集解决方案，最终引入开源成熟的APP端异常性能监控定位分析平台： 如百度、腾讯 。一步一步的让大家轻松应对开发中的bug。...

## App端异常基本情况介绍

常见的移动端异常

- Crash 在使用APP的过程中突然发生闪退现象
- 卡顿 出现画面的卡顿
- Exception 程序被catch起来的exception
- ANR 出现提示无响应弹框（只适用于android，ios不存在的）

## 数据收集方案解剖

- 统计数据
	- Crash 卡顿 Exception ANR 出先的次数
	- 影响用户量
	- 表的设计 （保存异常数据信息）
	- API接口的开发 （把异常信息存入数据表）

- 表的设计
	- id
	- app_type 手机类型（android、ios）
	- version_code 版本号
	- model 设备型号
	- did 设备号
	- type 异常类型（Crash 卡顿 Exception ANR）
	- description 异常描述
	- line 影响行数
	- create_time 发生的时间

## 成熟解决方案介绍 

- 第三方成熟服务
	- 听云
	- oneapm
	
- 如何使用
	- APP只需要继承第三方平台提供的SDK