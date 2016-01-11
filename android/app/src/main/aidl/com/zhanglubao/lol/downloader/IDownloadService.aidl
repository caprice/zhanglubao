package com.zhanglubao.lol.downloader;
import com.zhanglubao.lol.downloader.ICallback;
import com.zhanglubao.lol.downloader.DownloadInfo;
import java.util.Map;

interface IDownloadService{
	void registerCallback(ICallback callback);
	void unregister();
	void createDownload(in String videoId, in String videoName,String videoCover);
	void createDownloads(in String[] videoIds, in String[] videoNames,in String[] videoCovers);
	void down(in String taskId);
	void pause(in String taskId);
	boolean delete(in String taskId);
	boolean deleteAll();
	void refresh();
	Map getDownloadingData();
	void startNewTask();
	void stopAllTask();
	String getCurrentDownloadSDCardPath();
	void setCurrentDownloadSDCardPath(in String path);
	int getDownloadFormat();
	void setDownloadFormat(in int format);
	boolean canUse3GDownload();
	void setCanUse3GDownload(in boolean flag);
	void setTimeStamp(in long path);
}