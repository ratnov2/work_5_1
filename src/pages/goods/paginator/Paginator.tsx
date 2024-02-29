import { FC, useState } from "react";

interface IPaginator {
  totalItems: number;
  itemsPerPage: number;
  onPageChange: (page: number) => void;
}

export const Paginator: FC<IPaginator> = ({
  totalItems,
  itemsPerPage,
  onPageChange,
}) => {
  const [currentPage, setCurrentPage] = useState(1);

  const totalPages = Math.ceil(totalItems / itemsPerPage);

  const handlePageChange = async (page: number) => {
    await onPageChange(page);
    setCurrentPage(page);
  };

  const renderPageNumbers = () => {
    const pageNumbers = [];
    pageNumbers.push(
      <li key={1} className={currentPage === 1 ? "active" : ""}>
        <button onClick={() => handlePageChange(1)}>1</button>
      </li>
    );

    const leftBound = Math.max(2, currentPage - 4);
    const rightBound = Math.min(totalPages - 1, currentPage + 4);

    if (leftBound > 2) {
      pageNumbers.push(
        <li key="ellipsis-left" className="ellipsis">
          ...
        </li>
      );
    }

    for (let i = leftBound; i <= rightBound; i++) {
      pageNumbers.push(
        <li key={i} className={i === currentPage ? "active" : ""}>
          <button onClick={() => handlePageChange(i)}>{i}</button>
        </li>
      );
    }

    if (rightBound < totalPages - 1) {
      pageNumbers.push(
        <li key="ellipsis-right" className="ellipsis">
          ...
        </li>
      );
    }

    pageNumbers.push(
      <li
        key={totalPages}
        className={currentPage === totalPages ? "active" : ""}
      >
        <button onClick={() => handlePageChange(totalPages)}>
          {totalPages}
        </button>
      </li>
    );

    return pageNumbers;
  };

  return (
    <div>
      <ul>{renderPageNumbers()}</ul>
    </div>
  );
};

export default Paginator;
