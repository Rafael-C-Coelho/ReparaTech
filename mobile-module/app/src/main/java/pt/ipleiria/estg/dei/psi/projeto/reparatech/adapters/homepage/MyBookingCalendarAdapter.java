package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.TextView;

import java.text.SimpleDateFormat;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBookingCalendar;

public class MyBookingCalendarAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<MyBookingCalendar> myBookingCalendars;


    public MyBookingCalendarAdapter(Context context, ArrayList<MyBookingCalendar> myBookingCalendars) {
        this.context = context;
        this.myBookingCalendars = myBookingCalendars;
    }

    @Override
    public int getCount() {
        return myBookingCalendars.size();
    }

    @Override
    public Object getItem(int i) {
       return myBookingCalendars.get(i);
    }

    @Override
    public long getItemId(int i) {
        return myBookingCalendars.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null) {
            view = inflater.inflate(R.layout.item_calendar, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) view.getTag();
        if (viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }

        viewHolderList.update(myBookingCalendars.get(i));

        return view;
    }

    private class ViewHolderList {

        private TextView tvDate, tvTime, tvStatus;

        public ViewHolderList(View view){
            tvDate = view.findViewById(R.id.tvDate);
            tvTime = view.findViewById(R.id.tvTime);
            tvStatus = view.findViewById(R.id.tvStatus);
        }

        public void update(MyBookingCalendar myBookingCalendar) {

            SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
            SimpleDateFormat timeFormat = new SimpleDateFormat("HH:mm");

            tvDate.setText(myBookingCalendar.getDate().toString());
            tvTime.setText(myBookingCalendar.getTime().toString());
            tvStatus.setText(myBookingCalendar.getStatus());
        }
    }

}

