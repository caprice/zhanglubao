
package com.zhanglubao.lol.downloader;


public interface DownloadListener {
	void onStart();

	void onPause();

	void onCancel();

	void onException();

	void onFinish();

	void onProgressChange(double progress);

	void onWaiting();
}
