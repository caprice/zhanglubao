package com.zhanglubao.lol.model;

/**
 * Created by rocks on 15-5-28.
 */
public class SlideModel {
    String id;
    String type;
    String value_id;
    String url;
    String slide_picture;
    String title;


    public String getSlide_picture() {
        return slide_picture;
    }

    public void setSlide_picture(String slide_picture) {
        this.slide_picture = slide_picture;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public String getValue_id() {
        return value_id;
    }

    public void setValue_id(String value_id) {
        this.value_id = value_id;
    }
}
