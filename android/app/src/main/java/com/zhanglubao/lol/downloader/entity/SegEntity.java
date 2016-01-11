package com.zhanglubao.lol.downloader.entity;

/**
 * Created by rocks on 15-6-30.
 */
public class SegEntity {
    double seconds;
    String url;
    long size;

    public double getSeconds() {
        return seconds;
    }

    public void setSeconds(double seconds) {
        this.seconds = seconds;
    }

    public long getSize() {
        return size;
    }

    public void setSize(long size) {
        this.size = size;
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }
}
