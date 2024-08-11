
using ddApp.Models;
using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Repository
{
    public class CustomerRepository : ICustomerRepository
    {
        private readonly DataContext _context;

        public CustomerRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<Customer> GetCustomers()
        {
            return _context.Customers.ToList();
        }

        public Customer GetCustomer(int id)
        {
            return _context.Customers.Find(id);
        }

        public bool CustomerExists(int id)
        {
            return _context.Customers.Any(c => c.CustomerID == id);
        }

        public bool CreateCustomer(Customer customer)
        {
            _context.Customers.Add(customer);
            return Save();
        }

        public bool UpdateCustomer(Customer customer)
        {
            _context.Customers.Update(customer);
            return Save();
        }

        public bool DeleteCustomer(Customer customer)
        {
            _context.Customers.Remove(customer);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}
