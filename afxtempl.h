//virtual는 오버라이딩하면 그 전에 선언했던 함수는 실행되지 않는 것을 의미했지만,
//이것말고도 실행될 함수가 하나 더 있다는 의미도 있다.
#include <stdio.h>
#include <afxtempl.h>

void main() {
	CList<int, int> gildong;
	gildong.AddTail(7);
	gildong.AddTail(8);
	gildong.AddTail(12);

	POSITION pos = gildong.GetHeadPosition();

	for (int i = 0; i < gildong.GetCount(); i++) {
		printf("%d \n", gildong.GetNext(pos));
	}
	getchar();
}
