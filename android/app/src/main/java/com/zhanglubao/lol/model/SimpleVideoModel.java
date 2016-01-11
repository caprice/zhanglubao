package com.zhanglubao.lol.model;

import java.io.Serializable;

/**
 * Created by rocks on 15-5-28.
 */
public class SimpleVideoModel  implements Serializable{


    String id;
    String video_title;
    String video_picture;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getVideo_picture() {
        return video_picture;
    }

    public void setVideo_picture(String video_picture) {
        this.video_picture = video_picture;
    }

    public String getVideo_title() {
        return video_title;
    }

    public void setVideo_title(String video_title) {
        this.video_title = video_title;
    }
}
