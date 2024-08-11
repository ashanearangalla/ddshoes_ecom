using ddApp.Models;
using ddApp.Models;
using Microsoft.EntityFrameworkCore;
using System.Collections.Generic;

namespace ddApp.Interfaces
{
    public interface IOrderRepository
    {
        ICollection<Order> GetOrders();
        Order GetOrder(int id);
        bool OrderExists(int id);
        bool CreateOrder(Order order);
        bool UpdateOrder(Order order);
        bool DeleteOrder(Order order);
        bool Save();
        ICollection<Order> GetOrdersByUserId(int userId);

        public IEnumerable<Order> GetUserOrders();
        

        public IEnumerable<Order> GetUserOrdersByUserId(int userId);
       
    }
}
