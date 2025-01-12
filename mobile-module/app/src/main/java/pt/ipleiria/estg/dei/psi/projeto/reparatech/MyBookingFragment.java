package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;



import java.util.ArrayList;


import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.MyBookingAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class MyBookingFragment extends Fragment {

    private ListView lvMyBookingCalendar;
    private ArrayList<MyBooking> myBookings;
    private MyBookingAdapter adapter;
    private int page = 1;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_my_booking_calendar, container,false);

        lvMyBookingCalendar = view.findViewById(R.id.lvMyBookingCalendar);

        myBookings = ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB();
        if (myBookings.isEmpty()){
            ReparaTechSingleton.getInstance(getContext()).getBookingsFromApi(page);
            myBookings = ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB();
        }

        adapter = new MyBookingAdapter(getContext(), myBookings);
        lvMyBookingCalendar.setAdapter(adapter);

        return view;
    }
}