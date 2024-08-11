
using ddApp.Models;
using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Collections.Generic;
using System.Linq;
using Microsoft.EntityFrameworkCore;

namespace ddApp.Repository
{
    public class OrderRepository : IOrderRepository
    {
        private readonly DataContext _context;

        public OrderRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<Order> GetOrders()
        {
            return _context.Orders.ToList();
        }

        public Order GetOrder(int id)
        {
            return _context.Orders.Find(id);
        }

        public bool OrderExists(int id)
        {
            return _context.Orders.Any(o => o.OrderID == id);
        }

        public bool CreateOrder(Order order)
        {
            _context.Orders.Add(order);
            return Save();
        }

        public bool UpdateOrder(Order order)
        {
            _context.Orders.Update(order);
            return Save();
        }

        public bool DeleteOrder(Order order)
        {
            _context.Orders.Remove(order);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
        public ICollection<Order> GetOrdersByUserId(int userId)
        {
            return _context.Orders.Where(o => o.UserID == userId).ToList();
        }

        public IEnumerable<Order> GetUserOrders()
        {
            return _context.Orders
                .Include(o => o.OrderItems)
                .ThenInclude(oi => oi.Product)
                .ToList();
        }

        public IEnumerable<Order> GetUserOrdersByUserId(int userId)
        {
            return _context.Orders
                .Where(o => o.UserID == userId)
                .Include(o => o.OrderItems)
                .ThenInclude(oi => oi.Product)
                .ToList();
        }

    }
}
