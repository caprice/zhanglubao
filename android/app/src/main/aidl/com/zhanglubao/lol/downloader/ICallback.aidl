package com.zhanglubao.lol.downloader;
import com.zhanglubao.lol.downloader.DownloadInfo;

interface ICallback{
	void onChanged(in DownloadInfo info);
	void onFinish(in DownloadInfo info);
	void refresh();
}