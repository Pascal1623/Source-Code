//10진수를 2진수로 변환하는 프로그램
#include <stdio.h>
int main(void)
{
	int flag = 0x80;
	int num, i;

	printf("10진수를 입력하세요.:");
	scanf("%d", &num);

	for (i = 7; i >= 0; i--)
	{
		printf("%d", (num&flag) >> i);
		flag = flag >> 1;
	}

	return 0;
}