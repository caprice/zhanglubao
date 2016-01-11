package com.zhanglubao.lol.downloader;

public abstract class OnCreateDownloadListener {

    /**
     * 当每一个下载已准备的时候
     */
    public void onOneReady() {
    }

    /**
     * 当每一个下载失败
     */
    public void onOneFailed() {
    }

    /**
     * 当全部下载已准备的时候
     *
     * @param isNeedRefresh 是否需要刷新数据
     */
    public abstract void onfinish(boolean isNeedRefresh);

}
