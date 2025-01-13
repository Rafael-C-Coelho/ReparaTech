package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.SearchView;


import java.util.ArrayList;


import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.MyBookingAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateBookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoriesList;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class MyBookingFragment extends Fragment implements UpdateBookingListener {

    private ListView lvMyBookingCalendar;
    private ArrayList<MyBooking> myBookings;
    private MyBookingAdapter adapter;
    private SearchView searchView;
    private SwipeRefreshLayout swipeRefreshLayout;
    private boolean isLoading = false;
    private int page = 1;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_my_booking_calendar, container,false);

        setHasOptionsMenu(true);

        lvMyBookingCalendar = view.findViewById(R.id.lvMyBookingCalendar);
        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_bookings_layout);
        swipeRefreshLayout.setOnRefreshListener(this::onRefresh);

        myBookings = ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB();
        if (myBookings.isEmpty()){
            ReparaTechSingleton.getInstance(getContext()).getBookingsFromApi(page);
            myBookings = ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB();
        }
        adapter = new MyBookingAdapter(getContext(), myBookings);
        lvMyBookingCalendar.setAdapter(adapter);

        ReparaTechSingleton.getInstance(getContext()).setUpdateBookingListener(this);
        if (!myBookings.isEmpty()) {
            ReparaTechSingleton.getInstance(getContext()).updateBookings(myBookings.get(0));
        }

        return view;
    }

    public void onRefresh() {
        // Refresh the list
        isLoading = true;
        swipeRefreshLayout.setRefreshing(true);
        page = 1;
        ReparaTechSingleton.getInstance(getContext()).updateBookings(myBookings);
        myBookings.clear();
        swipeRefreshLayout.setRefreshing(false);
        //myBookings.addAll(ReparaTechSingleton.getInstance(getContext()).updateBookings(myBookings));
        myBookings.set(ReparaTechSingleton.getInstance(getContext()).updateBookings());
        adapter.notifyDataSetChanged();
        isLoading = false;
    }

    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        inflater.inflate(R.menu.search_menu, menu);
        MenuItem searchItem = menu.findItem(R.id.search_item);
        searchView = (SearchView) searchItem.getActionView();
        searchView.setQueryHint("Search Booking");
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<MyBooking> filteredBookings = new ArrayList<>();
                for (MyBooking myBooking : myBookings) {
                    if (myBooking.getDate().toLowerCase().contains(newText.toLowerCase())) {
                        filteredBookings.add(myBooking);
                    } else if (myBooking.getTime().toLowerCase().contains(newText.toLowerCase())) {
                        filteredBookings.add(myBooking);
                    }
                }
                lvMyBookingCalendar.setAdapter(new MyBookingAdapter(getContext(), filteredBookings));
                return true;
            }
        });
    }

    @Override
    public void updateBookings(MyBooking myBooking) {
        myBookings.clear();
        myBookings.(ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB());
        adapter.notifyDataSetChanged();
    }
}