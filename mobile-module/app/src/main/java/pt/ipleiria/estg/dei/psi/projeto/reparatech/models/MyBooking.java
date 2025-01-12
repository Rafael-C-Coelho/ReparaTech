package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;



public class MyBooking {

    private int id;
    private String time, date, status;

    public MyBooking(int id, String time, String date, String status) {
        this.id = id;
        this.time = time;
        this.date = date;
        this.status = status;
    }

    public int getId() {
        return id;
    }

    public String getTime() {
        return time;
    }

    public String getDate() {
        return date;
    }

    public String getStatus() {
        return status;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}

