using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;

namespace ddApp.Repository
{
    public class PartnerRepository : IPartnerRepository
    {
        private readonly DataContext _context;

        public PartnerRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<Partner> GetPartners()
        {
            return _context.Partners.ToList();
        }

        public Partner GetPartner(int id)
        {
            return _context.Partners.Find(id);
        }

        public bool PartnerExists(int id)
        {
            return _context.Partners.Any(p => p.PartnerID == id);
        }

        public bool CreatePartner(Partner partner)
        {
            _context.Partners.Add(partner);
            return Save();
        }

        public bool UpdatePartner(Partner partner)
        {
            _context.Partners.Update(partner);
            return Save();
        }

        public bool DeletePartner(Partner partner)
        {
            _context.Partners.Remove(partner);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}
