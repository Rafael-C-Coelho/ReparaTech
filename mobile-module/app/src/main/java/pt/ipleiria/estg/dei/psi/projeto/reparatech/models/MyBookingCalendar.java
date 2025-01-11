package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.sql.Time;
import java.util.Date;

public class MyBookingCalendar {

    private int id;
    private Time time;
    private Date date;
    private String status;

    public MyBookingCalendar(int id, Time time, Date date, String status) {
        this.id = id;
        this.time = time;
        this.date = date;
        this.status = status;
    }

    public int getId() {
        return id;
    }

    public Time getTime() {
        return time;
    }

    public Date getDate() {
        return date;
    }

    public String getStatus() {
        return status;
    }

    public void setTime(Time time) {
        this.time = time;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
