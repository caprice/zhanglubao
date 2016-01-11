

package com.zhanglubao.lol.downloader;

import java.util.HashMap;


public interface IDownload {

 

	/** 缩略图名字 */
	public static final String THUMBNAIL_NAME = "1.png";

	/** 配置文件名info */
	public static final String FILE_NAME = "info";

	/** SD卡发生插拔操作的广播动作 */
	public static final String ACTION_SDCARD_CHANGED = "com.zhanglubao.lol.downloader.service.download.ACTION_SDCARD_CHANGED";

	/** SD卡路径切换后的广播动作 */
	public static final String ACTION_SDCARD_PATH_CHANGED = "com.zhanglubao.lol.downloader.service.download.ACTION_SDCARD_PATH_CHANGED";

	/** 需要刷新页面的广播动作 */
	public static final String ACTION_THUMBNAIL_COMPLETE = "com.zhanglubao.lol.downloader.service.download.ACTION_THUMBNAIL_COMPLETE";

	/** 创建下载文件：每当一个创建完毕的广播动作 */
	public static final String ACTION_CREATE_DOWNLOAD_ONE_READY = "com.zhanglubao.lol.downloader.service.download.ACTION_CREATE_DOWNLOAD_ONE_READY";

	/** 创建下载文件：全部创建完毕的广播动作 */
	public static final String ACTION_CREATE_DOWNLOAD_ALL_READY = "com.zhanglubao.lol.downloader.service.download.ACTION_CREATE_DOWNLOAD_ALL_READY";

	/** 创建下载文件：每当一个创建失败的广播动作 */
	public static final String ACTION_CREATE_DOWNLOAD_ONE_FAILED = "com.zhanglubao.lol.downloader.service.download.ACTION_CREATE_DOWNLOAD_ONE_FAILED";

	/** 下载完成的广播动作 */
	public static final String ACTION_DOWNLOAD_FINISH = "com.zhanglubao.lol.downloader.service.download.ACTION_DOWNLOAD_FINISH";

	/** 下载公用的notify_id */
	public static final int NOTIFY_ID = 2046;

	/** 键-最后的消息taskid */
	public static final String KEY_LAST_NOTIFY_TASKID = "download_last_notify_taskid";

	/** 是否需要奥刷新 */
	public static final String KEY_CREATE_DOWNLOAD_IS_NEED_REFRESH = "isNeedRefresh";

	/**
	 * 是否存在该缓存
	 */
	public boolean existsDownloadInfo(String videoId);

	/**
	 * 是否已下载完成
	 */
	public boolean isDownloadFinished(String videoId);

	/**
	 * 获得本地下载的视频的相关信息
	 */
	public DownloadInfo getDownloadInfo(String videoId);

	/**
	 * Returns 正在缓存的视频缓存列表
	 */
	public HashMap<String, DownloadInfo> getDownloadingData();

	/**
	 * 开始下载任务
	 */
	public void startDownload(String taskId);

	/**
	 * 暂停下载任务
	 */
	public void pauseDownload(String taskId);

	/**
	 * 单个删除视频缓存
	 */
	public boolean deleteDownloading(String taskId);

	/**
	 * 删除全部正在缓存的视频
	 */
	public boolean deleteAllDownloading();

	/**
	 * 重新获取数据
	 */
	public void refresh();

	/***
	 * 开始一个新的下载任务
	 */
	public void startNewTask();

	public void stopAllTask();

	/**
	 * 获得当前下载SD卡路径/mnt/sdcard
	 */
	public String getCurrentDownloadSDCardPath();

	public void setCurrentDownloadSDCardPath(String path);


	/**
	 * 能否在3G环境下下载
	 */
	public boolean canUse3GDownload();

	public void setCanUse3GDownload(boolean flag);



	public int getDownloadFormat();

	public void setDownloadFormat(int format);



}
