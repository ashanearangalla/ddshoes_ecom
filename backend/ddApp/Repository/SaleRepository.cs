using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;

namespace ddApp.Repository
{
    public class SaleRepository : ISaleRepository
    {
        private readonly DataContext _context;

        public SaleRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<Sale> GetSales()
        {
            return _context.Sales.ToList();
        }

        public Sale GetSale(int id)
        {
            return _context.Sales.Find(id);
        }

        public bool SaleExists(int id)
        {
            return _context.Sales.Any(s => s.SaleID == id);
        }

        public bool CreateSale(Sale sale)
        {
            _context.Sales.Add(sale);
            return Save();
        }

        public bool UpdateSale(Sale sale)
        {
            _context.Sales.Update(sale);
            return Save();
        }

        public bool DeleteSale(Sale sale)
        {
            _context.Sales.Remove(sale);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}
