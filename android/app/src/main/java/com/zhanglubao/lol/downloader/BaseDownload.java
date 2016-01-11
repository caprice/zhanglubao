package com.zhanglubao.lol.downloader;

import android.content.Context;

import com.zhanglubao.lol.downloader.util.ConfigUtil;
import com.zhanglubao.lol.downloader.util.Logger;
import com.zhanglubao.lol.downloader.util.SDCardManager;
import com.zhanglubao.lol.util.PlayerUtil;

import java.io.File;
import java.io.FileInputStream;
import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by rocks on 15-6-28.
 */
public abstract class BaseDownload implements IDownload {

    public Context context;

    /** SD卡列表 */
    public ArrayList<SDCardManager.SDCardInfo> sdCard_list;

    @Override
    public final boolean existsDownloadInfo(String videoId) {
        return getDownloadInfo(videoId) == null ? false : true;
    }

    @Override
    public final boolean isDownloadFinished(String vid) {
        DownloadInfo info = getDownloadInfo(vid);
        if (info != null && info.getState() == DownloadInfo.STATE_FINISH)
            return true;
        return false;
    }

    @Override
    public final DownloadInfo getDownloadInfo(String videoId) {
        if (sdCard_list == null
                && (sdCard_list = SDCardManager.getExternalStorageDirectory()) == null) {
            return null;
        }
        for (int i = 0; i < sdCard_list.size(); i++) {
            DownloadInfo info = getDownloadInfoBySavePath(sdCard_list.get(i).path
                    + ConfigUtil.getDownloadPath() + videoId + "/");
            if (info != null) {
                return info;
            }
        }
        return null;
    }

    /**
     * 根据存储路径获得DownloadInfo
     */
    public final DownloadInfo getDownloadInfoBySavePath(String savePath) {
        try {
            File f = new File(savePath + FILE_NAME);
            if (f.exists() && f.isFile()) {
                String s = PlayerUtil.convertStreamToString(new FileInputStream(
                        f));
                DownloadInfo i = DownloadInfo.jsonToDownloadInfo(s);
                if (i != null && i.getState() != DownloadInfo.STATE_CANCEL) {
                    i.savePath = savePath;
                    return i;
                }
            }
        } catch (Exception e) {
            Logger.e("Download_BaseDownload",
                    "getDownloadInfoBySavePath()#savePath:" + savePath, e);
        }
        return null;
    }

    /**
     * 重新获取正在下载的数据
     *
     * @return
     */
    protected HashMap<String, DownloadInfo> getNewDownloadingData() {
        HashMap<String, DownloadInfo> downloadingData = new HashMap<String, DownloadInfo>();
        if (sdCard_list == null
                && (sdCard_list = SDCardManager.getExternalStorageDirectory()) == null) {
            return downloadingData;
        }
        for (int j = 0; j < sdCard_list.size(); j++) {
            File dir = new File(sdCard_list.get(j).path + ConfigUtil.getDownloadPath());
            if (!dir.exists())
                continue;
            String[] dirs = dir.list();
            for (int i = dirs.length - 1; i >= 0; i--) {
                String vid = dirs[i];
                DownloadInfo info = getDownloadInfoBySavePath(sdCard_list
                        .get(j).path + ConfigUtil.getDownloadPath() + vid + "/");
                if (info != null
                        && info.getState() != DownloadInfo.STATE_FINISH
                        && info.getState() != DownloadInfo.STATE_CANCEL) {
                    info.downloadListener = new DownloadListenerImpl(context,
                            info);
                    downloadingData.put(info.taskId, info);
                }
            }
        }
        return downloadingData;
    }

}
