package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleVideoModel;

import java.util.List;

/**
 * Created by rocks on 15-6-1.
 */
public class SimpleVideoListEntity {
    int status;
    List<SimpleVideoModel> videos;

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public List<SimpleVideoModel> getVideos() {
        return videos;
    }

    public void setVideos(List<SimpleVideoModel> videos) {
        this.videos = videos;
    }
}
