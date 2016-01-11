package com.zhanglubao.lol.evenbus;

import com.zhanglubao.lol.model.SimpleVideoModel;

/**
 * Created by rocks on 15-6-3.
 */
public class VideoEvent {

    SimpleVideoModel simpleVideoModel;

    public VideoEvent(SimpleVideoModel simpleVideoModel) {
        this.simpleVideoModel = simpleVideoModel;
    }

    public SimpleVideoModel getSimpleVideoModel() {
        return simpleVideoModel;
    }

    public void setSimpleVideoModel(SimpleVideoModel simpleVideoModel) {
        this.simpleVideoModel = simpleVideoModel;
    }
}
