package com.zhanglubao.lol.downloader.entity;

/**
 * Created by rocks on 15-7-1.
 */
public class ResultEntity {
    SingleEntity normal;
    SingleEntity high;
    SingleEntity hd;
    SingleEntity original;

    public SingleEntity getHd() {
        return hd;
    }

    public void setHd(SingleEntity hd) {
        this.hd = hd;
    }

    public SingleEntity getHigh() {
        return high;
    }

    public void setHigh(SingleEntity high) {
        this.high = high;
    }

    public SingleEntity getNormal() {
        return normal;
    }

    public void setNormal(SingleEntity normal) {
        this.normal = normal;
    }

    public SingleEntity getOriginal() {
        return original;
    }

    public void setOriginal(SingleEntity original) {
        this.original = original;
    }
}
