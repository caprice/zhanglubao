package com.zhanglubao.lol.evenbus;

import com.zhanglubao.lol.model.SimpleVideoModel;

/**
 * Created by rocks on 15-7-9.
 */
public class FavListClickEvent {
    SimpleVideoModel videoModel;

    public FavListClickEvent(SimpleVideoModel videoModel) {
        this.videoModel = videoModel;
    }

    public SimpleVideoModel getVideoModel() {
        return videoModel;
    }

    public void setVideoModel(SimpleVideoModel videoModel) {
        this.videoModel = videoModel;
    }
}
