package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import java.sql.Time;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.MyBookingCalendarAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBookingCalendar;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class MyBookingCalendarFragment extends Fragment {

    private ListView lvMyBookingCalendar;
    private ArrayList<MyBookingCalendar> myBookingCalendars;
    private MyBookingCalendarAdapter adapter;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_my_booking_calendar, container,false);

        lvMyBookingCalendar = view.findViewById(R.id.lvMyBookingCalendar);

        myBookingCalendars = new ArrayList<>();

        Calendar calendar = Calendar.getInstance();
        for(int i = 0; i<5; i++){
            calendar.set(2021 + i, Calendar.MAY, 10, 10, 0);
            Date date = calendar.getTime();
            Time time = new Time(calendar.getTimeInMillis());
            myBookingCalendars.add(new MyBookingCalendar(i + 1, time, date, "Pending"));
        }

        adapter = new MyBookingCalendarAdapter(getContext(),myBookingCalendars);
        lvMyBookingCalendar.setAdapter(adapter);

        return view;
    }
}