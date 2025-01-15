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
import android.widget.AbsListView;
import android.widget.ListView;
import android.widget.SearchView;


import java.util.ArrayList;


import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.MyBookingAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateBookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;
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

        if (myBookings.isEmpty()) {
            ReparaTechSingleton.getInstance(getContext()).getBookingsFromApi(page);
            ReparaTechSingleton.getInstance(getContext()).setBookingListener(success -> {
                if (success) {
                    myBookings.clear();
                    myBookings.addAll(ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB());
                    adapter.notifyDataSetChanged();
                }
                swipeRefreshLayout.setRefreshing(false);
            });
        }

        lvMyBookingCalendar.setOnScrollListener(new AbsListView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(AbsListView view, int scrollState) {
            }

            @Override
            public void onScroll(AbsListView view, int firstVisibleItem, int visibleItemCount, int totalItemCount) {
                if (!isLoading && (firstVisibleItem + visibleItemCount >= totalItemCount) && totalItemCount > 0) {
                    fetchMoreBookings();
                }
            }
        });

        return view;
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

    private void onRefresh() {
        isLoading = true;
        swipeRefreshLayout.setRefreshing(true);
        page = 1;

        ReparaTechSingleton.getInstance(getContext()).clearBookingsDB();
        ReparaTechSingleton.getInstance(getContext()).getBookingsFromApi(page);
        ReparaTechSingleton.getInstance(getContext()).setBookingListener(success -> {
            if (success) {
                myBookings.clear();
                myBookings.addAll(ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB());
                adapter.notifyDataSetChanged();
            }
            swipeRefreshLayout.setRefreshing(false);
            isLoading = false;
        });
    }

    public void updateBookings(MyBooking myBooking) {
        for (int i = 0; i < myBookings.size(); i++) {
            if (myBookings.get(i).getId() == myBooking.getId()) {
                myBookings.set(i, myBooking);
                adapter.notifyDataSetChanged();
                break;
            }
        }
    }

    private void fetchMoreBookings() {
        isLoading = true;
        int prevBookingsSize = myBookings.size();
        ReparaTechSingleton.getInstance(getContext()).getBookingsFromApi(++page);
        ReparaTechSingleton.getInstance(getContext()).setBookingListener(success -> {
            if (success) {
                int currentBookingsSize = ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB().size();
                if (currentBookingsSize == prevBookingsSize) {
                    isLoading = false;
                    return;
                }
                myBookings.addAll(ReparaTechSingleton.getInstance(getContext()).getMyBookingsDB());
                adapter.notifyDataSetChanged();
            }
            isLoading = false;
        });
    }
}